<?php


include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/update.php");

function getAllUpdates() {

    $result = array();

    $conn = getConnection();
    $statement = $conn->prepare("SELECT * FROM `update`");

    if (!$statement->execute()) {
        mysqli_close($conn);
        throw new Exception($statement->error);
    }

    $res = $statement->get_result();

    while ($row = $res->fetch_assoc()) {
        array_push($result, update::loadWithId($row["update_id"]));
    }

    mysqli_free_result($res);
    mysqli_close($conn);

    return $result;
}

function getAllRaspberryThatCompletedUpdates() {

    $updates = getAllUpdates();
    $result = array();


    for ($i = 0; $i < count($updates); $i++) {

        $conn = getConnection();

        $statement = $conn->prepare("SELECT raspberry_pi_id FROM update_completed WHERE update_completed.update_id = ?");
        $statement->bind_param("i", $updates[$i]->getUpdateId());

        if (!$statement->execute()) {
            mysqli_close($conn);
            throw new Exception($statement->error);
        }

        $res = $statement->get_result();

        while ($row = $res->fetch_assoc()) {

            array_push($result, array($updates[$i], raspberry_pi::loadWithId($row["raspberry_pi_id"])));
        }

        mysqli_free_result($res);
        mysqli_close($conn);
    }

    return $result;
}
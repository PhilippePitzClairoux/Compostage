 <?php


  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/raspberry_pi.php");
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");
if($_POST){


  if(isset($_POST['Add'])){

        $modele = sanitize_input($_POST['modele']);
        $user = sanitize_input($_POST['user']);
        $zone = sanitize_input($_POST['zone']);
        $date = sanitize_input($_POST['date']);
        $capacity = sanitize_input($_POST['capacity']);
        raspberry_pi::createNewRaspberryPi($modele,$user,$zone,$date,$capacity);

        echo "creation successful";


  }
  else if(isset($_POST['Alter'])){

        $id=sanitize_input($_POST['id']);
        $modele = sanitize_input($_POST['modele']);
        $user = sanitize_input($_POST['user']);
        $zone = sanitize_input($_POST['zone']);
        $date = sanitize_input($_POST['date']);
        $capacity = sanitize_input($_POST['capacity']);

        modifyRaspberryPi($modele,$user,$zone,$date,$capacity,$id);

  }
  else if(isset($_POST['Delete'])){

        $id=sanitize_input($_POST['id']);

        deleteRaspberryPi($id);

  }

}

function fetchAllRasPi(){
  $conn = getConnection();
  $statement = $conn->prepare("SELECT `raspberry_pi`.`raspberry_pi_id`,`zone`.`zone_name`,`bed`.`bed_name` FROM `raspberry_pi` JOIN `zone` ON `raspberry_pi`.`zone_id`=`zone`.`zone_id` JOIN `bed` ON`zone`.`bed_id`=`bed`.`bed_id`");
  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }

  $result = $statement->get_result();

  return $result;
  /*while ($row=mysqli_fetch_row($result))
      {
      echo $row[0],$row[1];
    }*/
}

function fetchAllUsers(){
  $conn = getConnection();

  $statement = $conn->prepare("SELECT `username` FROM `users` ");
  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }

  $result = $statement->get_result();

  return $result;
}

function fetchAllModels(){
  $conn = getConnection();

  $statement = $conn->prepare("SELECT `raspberry_pi_type` FROM `raspberry_pi` ");
  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }

  $result = $statement->get_result();

  return $result;
}

function fetchAllZones(){
  $conn = getConnection();

  $statement = $conn->prepare("SELECT `zone_id`, `zone_name` FROM `zone` ");
  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }

  $result = $statement->get_result();

  return $result;
}

function fetchAllIds(){
  $conn = getConnection();

  $statement = $conn->prepare("SELECT `raspberry_pi_id` FROM `raspberry_pi` ");
  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }

  $result = $statement->get_result();

  return $result;
}

function modifyRaspberryPi($raspberry_pi_type_id,
                           $raspberry_pi_user,
                           $raspberry_pi_zone_id,
                           $raspberry_pi_aquisition_date,
                           $raspberry_pi_capcity,
                           $raspberry_pi_id){

  $conn = getConnection();

  $statement = $conn->prepare("UPDATE `raspberry_pi` SET `zone_id` = ?, `user_id` = ?,`raspberry_pi_type`=?, `raspberry_pi_aquisition_date` = ?, `raspberry_pi_capacity` = ? WHERE `raspberry_pi`.`raspberry_pi_id` = ? ");

  $statement->bind_param("isssii", $raspberry_pi_zone_id,
      $raspberry_pi_user, $raspberry_pi_type_id,
      $raspberry_pi_aquisition_date, $raspberry_pi_capcity,$raspberry_pi_id);

  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }
  else{
    echo "Alter successful";
  }
}

function deleteRaspberryPi($raspberry_pi_id){

  $conn = getConnection();

  $statement = $conn->prepare("DELETE FROM `raspberry_pi` WHERE `raspberry_pi_id`=? ");

  $statement->bind_param("i", $raspberry_pi_id);

  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }
  else{
    echo "Delete successful";
  }
}
 ?>

<html>
<script src="compostage.js">

</script>
</html>

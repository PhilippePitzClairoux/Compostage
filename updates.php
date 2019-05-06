<!--********************************
    Fichier : updates.php
    Auteur : Philippe Pitz Clairoux
    Fonctionnalité :
    Date : 2019-05-04

    Vérification :
    Date                Nom                 Approuvé
    ====================================================

    Historique de modifications :
    Date                Nom                 Description
    ======================================================

 ********************************/-->
<?php
    //check if user is loged in
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");

    create_session();

    if (!check_if_valid_session_exists()) {
        header("Location: index.html");
        exit();
    }

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/UpdateManager.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/zone.php");

?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style.css" />
        <title>Updates</title>
    </head>
    <body class="center col-10 col-m-12 col-t-12">

    <header class="col-12 col-m-12 col-t-12">
        <div>
            <img src="img/logo.png">
        </div>

        <nav class="col-12 col-m-12 col-t-12">
            <ul class="col-12 col-m-12 col-t-12">
                <a href="dashboard.php"><li class="col-6 col-m-12 col-t-6 elementNav">Dashboard</li></a>
                <a href="controller/LogoutManager.php"><li class="col-6 col-m-12 col-t-6 elementNav">Logout</li></a>
            </ul>
        </nav>
    </header>
    <section class="col-12 col-m-12 col-t-12 center">
        <br>
        <br>
        <br>
    <table border="1" style="margin: auto">
        <tr>
            <td>Update name</td>
            <td>Update state</td>
            <td>Raspberry Pi id</td>
            <td>Raspberry Pi zone</td>
            <td>Raspberry Pi bed</td>
            <td>Date of the completion</td>
        </tr>

            <?php

                $data = getAllRaspberryThatCompletedUpdates();

                foreach($data as $values) {

                    $update = $values[0];
                    $raspberry_pi = $values[1];
                    $zone = zone::loadWithId($raspberry_pi->getZoneId());

                    echo "<tr>";
                    echo "<td>" . $update->getUpdateName() . "</td>";
                    echo "<td>" . ($update->getUpdateState())->getUpdateState() . "</td>";
                    echo "<td>" . $raspberry_pi->getRaspberryPiId() . "</td>";
                    echo "<td>" . $zone->getZoneName() . "</td>";
                    echo "<td>" . ($zone->getBed())->getBedName() . "</td>";
                    echo "<td>" . $update->getUpdateDate() . "</td>";
                    echo "</tr>";
                }
            ?>
    </table>
        <br>
        <br>
        <br>
    </section>

    <footer class="footer col-12 col-m-12 col-t-12 left">
        <div>
            &copy; Copyright 2019 ANNELIDA
        </div>
    </footer>
    <script src="JS/form_validation.js">

    </script>

    </body>
</html>

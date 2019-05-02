
<!--********************************
    Fichier : ctrl_list_rasp.php
    Auteur : Benoit Audettr-Chavigny
    Fonctionnalité : FR
    Date : 2019-05-01

    Vérification :
    Date                Nom                 Approuvé
    ====================================================

    Historique de modifications :
    Date                Nom                 Description
    ======================================================

 ********************************/-->
 <?php

  include_once("../controller/data_management/raspberry_pi.php");

  $ras= new raspberry_pi();

  $ras->loadWithId(1);

  $ras->fetch_data();

  echo $ras->getRaspberryPiType();


 ?>

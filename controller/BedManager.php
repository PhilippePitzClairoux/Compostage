
<!--********************************
    Fichier : BedManager.php
    Auteur : Benoit Audettr-Chavigny
    Fonctionnalité : FZ
    Date : 2019-05-04

    Vérification :
    Date                Nom                 Approuvé
    ====================================================

    Historique de modifications :
    Date                Nom                 Description
    ======================================================

 ********************************/-->
 <?php

  //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/data_management/bed.php");
  //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/SecurityUtils.php");
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/bed.php");
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");
if($_POST){


  if(isset($_POST['Ajouter'])){

        $name = sanitize_input($_POST['nom']);
        bed::createNewBed($name);

        echo "creation successful";


  }
  else if(isset($_POST['Modifier'])){

        $id=sanitize_input($_POST['id']);
        $name = sanitize_input($_POST['nom']);

        modifyBed($id,$name);

  }
  else if(isset($_POST['Supprimer'])){

        $id=sanitize_input($_POST['id']);

        deleteBed($id);

  }

}

function fetchAllBeds(){
  $conn = getConnection();

  $statement = $conn->prepare("SELECT `bed_name`, `bed_id` FROM `bed` ");
  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }

  $result = $statement->get_result();

  return $result;
}

function fetchAllIds(){
  $conn = getConnection();

  $statement = $conn->prepare("SELECT `bed_id` FROM `bed` ");
  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }

  $result = $statement->get_result();

  return $result;
}

function modifyBed($bed_id,$bed_name){

  $conn = getConnection();

  $statement = $conn->prepare("UPDATE `bed` SET `bed_name` = ? WHERE `bed`.`bed_id` = ? ");

  $statement->bind_param("si", $bed_name, $bed_id);

  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }
  else{
    echo "Alter successful";
  }
}

function deleteBed($bed_id){

  $conn = getConnection();

  $statement = $conn->prepare("DELETE FROM `bed` WHERE `bed_id`=? ");

  $statement->bind_param("i", $bed_id);

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

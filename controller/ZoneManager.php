 <?php

  //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/data_management/zone.php");
  //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/SecurityUtils.php");
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/zone.php");
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");
if($_POST){


  if(isset($_POST['Add'])){

        $name = sanitize_input($_POST['nom']);
        $bed = sanitize_input($_POST['bac']);
        zone::createNewZone($name,$bed);

        echo "creation successful";


  }
  else if(isset($_POST['Alter'])){

        $id=sanitize_input($_POST['id']);
        $name = sanitize_input($_POST['nom']);
        $bed = sanitize_input($_POST['bac']);

        modifyZone($id,$name,$bed);

  }
  else if(isset($_POST['Delete'])){

        $id=sanitize_input($_POST['id']);

        deleteZone($id);

  }

}

function fetchAllZones(){
  $conn = getConnection();
  $statement = $conn->prepare("SELECT `zone_name`,`zone_id` FROM  `zone`");
  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }

  $result = $statement->get_result();

  return $result;
}


function fetchAllBeds(){
  $conn = getConnection();

  $statement = $conn->prepare("SELECT `bed_id`, `bed_name` FROM `bed` ");
  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }

  $result = $statement->get_result();

  return $result;
}

function fetchAllIds(){
  $conn = getConnection();

  $statement = $conn->prepare("SELECT `zone_id` FROM `zone` ");
  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }

  $result = $statement->get_result();

  return $result;
}

function modifyZone($zone_id,$zone_name,$bed_id){

  $conn = getConnection();

  $statement = $conn->prepare("UPDATE `zone` SET `bed_id` = ?, `zone_name` = ? WHERE `zone`.`zone_id` = ? ");

  $statement->bind_param("isi", $bed_id, $zone_name, $zone_id);

  if (!$statement->execute()) {
      mysqli_close($conn);
      throw new Exception($statement->error);
  }
  else{
    echo "Alter successful";
  }
}

function deleteZone($zone_id){

  $conn = getConnection();

  $statement = $conn->prepare("DELETE FROM `zone` WHERE `zone_id`=? ");

  $statement->bind_param("i", $zone_id);

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

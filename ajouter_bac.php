
<!--********************************
    Fichier : ajouter_bac.php
    Auteur : Benoit Audettr-Chavigny
    Fonctionnalité : FB
    Date : 2019-04-26

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

  //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/BedManager.php");
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/BedManager.php");
  $url= "../controller/BedManager.php";
 ?>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Create/Modify bed</title>
  </head>
  <body>

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

    <form class="inventoryForm" method="post" action=<?php  echo $url?>>
      <h1 id="title"> bed</h1>
      <label for="id">Id du bac</label><select name="id" id="id" required>
        <?php
          $result=fetchAllBeds();

          while ($row=$result->fetch_assoc())
          {
              print_r($row);
              echo "<option value=".$row["bed_id"].">". $row["bed_id"] . ". " . $row["bed_name"] ."</option>";
          }

          mysqli_free_result($result);
        ?></select><br />
      <label for="nom">Nom Bac: </label> <input type="text" name="nom" id="nom" required /><br />
      <button class="button inButton" type="button" onclick="location.href='liste_bac.php'">Cancel</button>
      <button class="button inButton" type="submit" id="actionButton"></button>
    </form>

    <footer class="footer col-12 col-m-12 col-t-12 left">
  		<div>
  			&copy; Copyright 2019 ANNELIDA
  		</div>
  	</footer>
    <script src="JS/form_validation.js">

    </script>

  </body>
</html>


<!--********************************
    Fichier : ajouter_ras_pi.php
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
  //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/RaspberryPiManager.php");
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/RaspberryPiManager.php");
  $url= "../controller/RaspberryPiManager.php";
 ?>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="JS/style.css" />
    <title>Ajouter/modifier Rasberry_pi</title>
  </head>
  <body>

    <header class="col-12 col-m-12 col-t-12">
  		<div>
  			<img src="JS/logo.png">
  		</div>

  		<nav class="col-12 col-m-12 col-t-12">
  			<ul class="col-12 col-m-12 col-t-12">
  				<a href=""><li class="col-3 col-m-12 col-t-3 elementNav">Accueil</li></a>
  				<a href=""><li class="col-3 col-m-12 col-t-3 elementNav">page2</li></a>
  				<a href=""><li class="col-3 col-m-12 col-t-3 elementNav">page3</li></a>
  				<a href=""><li class="col-3 col-m-12 col-t-3 elementNav">page4</li></a>
  			</ul>
  		</nav>
  	</header>

    <form class="inventoryForm" method="post" action=<?php  echo $url?>>
      <h1 id="title"> rasberry pi</h1>
      <label for="id" id="labelId">ID Rasberry pi: </label> <select name="id" id="id" required>
        <?php
          $result=fetchAllIds();

          while ($row=mysqli_fetch_row($result))
          {
              echo "<option value=".$row[0].">".$row[0]."</option>";
          }

          mysqli_free_result($result);
        ?>
      </select><br />
      <label for="user">User: </label> <select name="user" id="user" required>
        <?php
          $result=fetchAllUsers();

          while ($row=mysqli_fetch_row($result))
          {
              echo "<option value=".$row[0].">".$row[0]."</option>";
          }
            mysqli_free_result($result);
        ?></select><br />
      <label for="zone">Zone: </label> <select name="zone" id="zone" required>
        <?php
          $result=fetchAllZones();

          while ($row=mysqli_fetch_row($result))
          {
              echo "<option value=".$row[0].">".$row[1]."</option>";
          }

            mysqli_free_result($result);
        ?></select><br />
      <label for="modele">Model: </label> <select name="modele" id="modele" required>
        <?php
          $result=fetchAllModels();

          while ($row=mysqli_fetch_row($result))
          {
              echo "<option value=".$row[0].">".$row[0]."</option>";
          }
             mysqli_free_result($result);
        ?></select><br />
      <label for="date">Aquisition date: </label> <input type="date" name="date" id="date" required /><br />
      <label for="capacity">Capacity: </label> <input type="text" name="capacity" id="capacity" required /><br />
      <button class="button inButton" type="button" onclick="location.href='liste_rasp_pi.php'">Cancel</button>
      <button class="button inButton" type="submit" id="actionButton"></button>
    </form>

    <footer class="footer col-12 col-m-12 col-t-12 left">
  		<div>
  			&copy; Copyright 2019 ANNELIDA
  		</div>
  	</footer>

    <script src="compostage.js">

    </script>

  </body>
</html>

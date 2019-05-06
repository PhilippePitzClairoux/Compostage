
<!--********************************
    Fichier : ajouter_zone.php
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

     //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/ZoneManager.php");
      include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ZoneManager.php");
      $url= "../controller/ZoneManager.php";
 ?>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Add/alter Zone</title>
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
          <h1 id="title"> zone</h1>
          <label for="id">Zone Id: </label><select name="id" id="id" required>
            <?php
              $result=fetchAllIds();

              while ($row=mysqli_fetch_row($result))
              {
                  echo "<option value=".$row[0].">".$row[0]."</option>";
              }

                 mysqli_free_result($result);
            ?></select><br />
          <label for="nom">Zone name: </label> <input type="text" name="nom" id="nom" required /><br />
          <label for="bac">Bac: </label> <select name="bac" id="bac" required>
            <?php
              $result=fetchAllBeds();

              while ($row=mysqli_fetch_row($result))
              {
                  echo "<option value=".$row[0].">".$row[1]."</option>";
              }
                mysqli_free_result($result);
            ?></select><br />
          <button class="button inButton" type="button" onclick="location.href='liste_zone.php'">Cancel</button>
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

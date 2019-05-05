
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
  //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/ZoneManager.php");
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ZoneManager.php");
  $url= "../controller/ZoneManager.php";
 ?>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="inventory_style.css" />
    <title>Ajouter/modifier Zone</title>
  </head>
<body onload="init()" class="col-10 col-m-12 col-t-12">

  <header class="col-12 col-m-12 col-t-12">
    <div>
      <img src="logo.png">
    </div>

    <nav class="col-12 col-m-12 col-t-12">
      <ul class="col-12 col-m-12 col-t-12">
        <a href="dashboard.html"><li class="col-3 col-m-12 col-t-3 elementNav">Main</li></a>
        <a href=""><li class="col-3 col-m-12 col-t-3 elementNav">page2</li></a>
        <a href=""><li class="col-3 col-m-12 col-t-3 elementNav">page3</li></a>
        <a href="stats.html"><li class="col-3 col-m-12 col-t-3 elementNav">page4</li></a>
      </ul>
    </nav>
  </header>
    <form method="post" action=<?php  echo $url?>>
      <h1>Ajouter une zone</h1>
      <label for="id">Id de la zone</label><select name="id" id="id" required>
        <?php
          $result=fetchAllIds();

          while ($row=mysqli_fetch_row($result))
          {
              echo "<option value=".$row[0].">".$row[0]."</option>";
          }

             mysqli_free_result($result);
        ?></select><br />
      <label for="nom">Nom de la Zone: </label> <input type="text" name="nom" id="nom" required /><br />
      <label for="bac">bac: </label> <select name="bac" id="bac" required>
        <?php
          $result=fetchAllBeds();

          while ($row=mysqli_fetch_row($result))
          {
              echo "<option value=".$row[0].">".$row[1]."</option>";
          }
            mysqli_free_result($result);
        ?></select><br />
      <button type="button" onclick="location.href='liste_zone.php'">Cancel</button>
      <button type="submit" id="actionButton"></button>
    </form>

    <script src="compostage.js">

    </script>
  </body>
</html>


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
  //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/BedManager.php");
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/BedManager.php");
  $url= "../controller/BedManager.php";
 ?>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="inventory_style.css" />
    <title>Ajouter/modifier Bac</title>
  </head>
  <body>

    <form method="post" action=<?php  echo $url?>>
      <h1>Ajouter un bac</h1>
      <label for="id">Id du bac</label><select name="id" id="id" required>
        <?php
          $result=fetchAllIds();

          while ($row=mysqli_fetch_row($result))
          {
              echo "<option value=".$row[0].">".$row[0]."</option>";
          }

          mysqli_free_result($result);
        ?></select><br />
      <label for="nom">Nom Bac: </label> <input type="text" name="nom" id="nom" required /><br />
      <button type="button" onclick="location.href='liste_bac.php'">Cancel</button>
      <button type="submit" id="actionButton"></button>
    </form>
    <script src="compostage.js">

    </script>

  </body>
</html>

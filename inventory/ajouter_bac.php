
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
    <link rel="stylesheet" href="JS/style.css" />
    <title>Ajouter/modifier Bac</title>
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
      <h1 id="title"> bed</h1>
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
      <button class="button inButton" type="button" onclick="location.href='liste_bac.php'">Cancel</button>
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

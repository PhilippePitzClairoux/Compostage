
<!--********************************
    Fichier : liste_rasp_pi.php
    Auteur : Benoit Audettr-Chavigny
    Fonctionnalité : FR
    Date : 2019-04-25

    Vérification :
    Date                Nom                 Approuvé
    ====================================================

    Historique de modifications :
    Date                Nom                 Description
    2019-04-30          Benoit              Javascript included
    2019-05-01          Benoit              Javascript moved to JS file
    ======================================================

 ********************************/-->
 <?php
  //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/RaspberryPiManager.php")
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/RaspberryPiManager.php");
 ?>
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="JS/style.css" />
    <title>Liste Rasberry pi</title>
  </head>
  <body class="left col-10 col-m-12 col-t-12">

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

<main class="col-12 col-m-12 col-t-12 inMain left">

  <h1>List of Raspberry pi</h1>

    <table class="col-m-12 col-t-10 col-8 inTable left">

      <thead>
        <tr>
          <th class="inTableHead">
            ID
          </th>
          <th class="inTableHead">
            Bed
          </th>
          <th class="inTableHead">
            Zone
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="inTableElement" colspan="3">
            <ul class="left liste">

                <?php
                  $result=fetchAllRasPi();

                  while ($row=mysqli_fetch_row($result))
                  {
                      echo "<li class=\"listElement\"><ul><li>".$row[0]."</li><li>".$row[2]."</li><li>".$row[1]."</li></ul></li>";
                  }
                ?>
            </ul>
          </td>
        </tr>
      </tbody>

    </table>
    <section class="buttonHolder">
      <button class="left button inButton" id="ajouter" onclick="checkAction('Add','ajouter_ras_pi.php')">Add</button><br />
      <button class="left button inButton" id="modifier" onclick="checkAction('Alter','ajouter_ras_pi.php')">Alter</button><br />
      <button class="left button inButton" id="supprimer" onclick="checkAction('Delete','ajouter_ras_pi.php')">Delete</button><br />
      <button class="left button inButton" >Ok</button><br />
    </section>

    </main>

    <footer class="footer col-12 col-m-12 col-t-12 left">
  		<div>
  			&copy; Copyright 2019 ANNELIDA
  		</div>
  	</footer>

    <script src="compostage.js">

    </script>

  </body>
</html>

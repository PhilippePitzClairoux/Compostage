
<!--********************************
    Fichier : liste_zone.php
    Auteur : Benoit Audettr-Chavigny
    Fonctionnalité : FZ
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
  //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/ZoneManager.php")
  include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/RaspberryPiManager.php");
 ?>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="inventory_style.css" />
    <title>Liste Zone</title>
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

    <table class="col-m-6 left">

      <thead>
        <tr>
          <th>
            Nom Zone
          </th>
          <th>
            ID
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="2">
            <ul class="left">
              <?php
                $result=fetchAllZones();

                while ($row=mysqli_fetch_row($result))
                {
                    echo "<li><ul><li class=\"col-m-6\">".$row[0]."</li><li class=\"col-m-6\">".$row[1]."</li></ul></li>";
                }
                  mysqli_free_result($result);
              ?>
            </ul>
          </td>
        </tr>
      </tbody>

    </table>

    <button class="left" id="ajouter" onclick="checkAction('Ajouter','ajouter_zone.php')">Ajouter</button><br />
    <button class="left" id="modifier" onclick="checkAction('Modifier','ajouter_zone.php')">Modifier</button><br />
    <button class="left" id="supprimer" onclick="checkAction('Supprimer','ajouter_zone.php')">Supprimer</button><br />
    <button class="left">Ok</button><br />

    <script src="compostage.js">

    </script>


  </body>
</html>

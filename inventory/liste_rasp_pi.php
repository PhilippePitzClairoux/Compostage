
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
    <meta charset="utf-8" />
    <link rel="stylesheet" href="inventory_style.css" />
    <title>Liste Rasberry pi</title>
  </head>
  <body>


    <table class="col-m-6 left">

      <thead>
        <tr>
          <th>
            ID
          </th>
          <th>
            Bac
          </th>
          <th>
            Zone
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="3">
            <ul class="left">

                <?php
                  $result=fetchAllRasPi();

                  while ($row=mysqli_fetch_row($result))
                  {
                      echo "<li><ul><li>".$row[0]."</li><li>".$row[1]."</li><li>".$row[2]."</li></ul></li>";
                  }

                    mysqli_free_result($result);
                ?>
            </ul>
          </td>
        </tr>
      </tbody>

    </table>

    <button class="left" id="ajouter" onclick="checkAction('Ajouter','ajouter_ras_pi.php')">Ajouter</button><br />
    <button class="left" id="modifier" onclick="checkAction('Modifier','ajouter_ras_pi.php')">Modifier</button><br />
    <button class="left" id="supprimer" onclick="checkAction('Supprimer','ajouter_ras_pi.php')">Supprimer</button><br />
    <button class="left" >Ok</button><br />

    <script src="compostage.js">

    </script>

  </body>
</html>

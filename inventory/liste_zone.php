
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
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="inventory_style.css" />
    <title>Liste Zone</title>
  </head>
  <body>


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
              <li>
                example
              </li>
              <li>
                example
              </li>
              <li>
                example
              </li>
              <li>
                example
              </li>
              <li>
                example
              </li>
              <li>
                example
              </li>
              <li>
                example
              </li>
            </ul>
          </td>
        </tr>
      </tbody>

    </table>

    <button class="left" id="ajouter" onclick="checkAction('ajouter','ajouter_zone.php')">Ajouter</button><br />
    <button class="left" id="modifier" onclick="checkAction('modifier','ajouter_zone.php')">Modifier</button><br />
    <button class="left">Supprimer</button><br />
    <button class="left">Ok</button><br />

    <script src="compostage.js">
      
    </script>


  </body>
</html>

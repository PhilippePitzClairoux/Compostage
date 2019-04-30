
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
    ======================================================

 ********************************/-->
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

    <button class="left" id="ajouter" onclick="checkAction('ajouter','ajouter_ras_pi.php')">Ajouter</button><br />
    <button class="left" id="modifier" onclick="checkAction('modifier','ajouter_ras_pi.php')">Modifier</button><br />
    <button class="left">Supprimer</button><br />
    <button class="left">Ok</button><br />

    <script>
      function checkAction(action, url){
        document.cookie ="action="+action;
        window.location.href=url;

      }
    </script>

  </body>
</html>

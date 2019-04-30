
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
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="inventory_style.css" />
    <title>Ajouter/modifier Zone</title>
  </head>
  <body>

    <form method="post">
      <h1>Ajouter une zone</h1>
      <label for="nom">Nom de la Zone: </label> <input type="text" name="nom" id="nom" required /><br />
      <label for="bac">bac: </label> <select name="bac" id="bac" required></select><br />
      <button type="button" onclick="location.href='liste_zone.php'">Cancel</button>
      <button type="submit">Ajouter</button>
    </form>


  </body>
</html>

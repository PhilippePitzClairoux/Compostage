
<!--********************************
    Fichier : ajouter_ras_pi.php
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
    <link rel="stylesheet" href="style.css" />
    <title>Ajouter/modifier Rasberry_pi</title>
  </head>
  <body>

    <form method="post">
      <label for="id">ID Rasberry pi: </label> <input type="text" name="nom" id="nom" required /><br />
      <label for="bac">Bac: </label> <select name="bac" id="bac" required></select><br />
      <label for="zone">Zone: </label> <select name="zone" id="zone" required></select><br />
      <label for="modele">Modèle: </label> <select name="modele" id="modele" required></select><br />
      <button type="button" onclick="location.href='liste_rasp_pi.php'">Cancel</button>
      <button type="submit">Ajouter</button>
    </form>


  </body>
</html>


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
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="inventory_style.css" />
    <title>Ajouter/modifier Bac</title>
  </head>
  <body>

    <form method="post">
      <h1>Ajouter un bac</h1>
      <label for="nom">Nom Bac: </label> <input type="text" name="nom" id="nom" required /><br />
      <button type="button" onclick="location.href='liste_bac.php'">Cancel</button>
      <button type="submit">Ajouter</button>
    </form>


  </body>
</html>

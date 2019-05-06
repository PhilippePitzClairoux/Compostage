
<!--********************************
    Fichier : liste_bac.php
    Auteur : Benoit Audettr-Chavigny
    Fonctionnalité : FB
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

    //check if user is loged in
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");
    create_session();

    if (!check_if_valid_session_exists()) {
     header("Location: index.html");
     exit();
    }

    //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/BedManager.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/BedManager.php");
 ?>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Liste Bac</title>
  </head>
  <body class="left col-10 col-m-12 col-t-12">

    <header class="col-12 col-m-12 col-t-12">
  		<div>
  			<img src="img/logo.png">
  		</div>

  		<nav class="col-12 col-m-12 col-t-12">
            <ul class="col-12 col-m-12 col-t-12">
                <a href="dashboard.php"><li class="col-6 col-m-12 col-t-6 elementNav">Dashboard</li></a>
                <a href="controller/LogoutManager.php"><li class="col-6 col-m-12 col-t-6 elementNav">Logout</li></a>
            </ul>
  		</nav>
  	</header>
    <section>
<main class="col-12 col-m-12 col-t-12 inMain left">

  <h1>List of beds</h1>

    <table class="col-m-12 col-t-10 col-8 inTable left">

      <thead>
        <tr>
          <th class="inTableHead">
            Bed name
          </th>
          <th class="inTableHead">
            Bed Id
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="inTableElement" colspan="2">
            <ul class="left liste">
              <?php
                $result=fetchAllBeds();

                while ($row=mysqli_fetch_row($result))
                {
                    echo "<li class=\"listElement\"><ul><li class=\"col-m-6\">".$row[0]."</li><li class=\"col-m-6\">".$row[1]."</li></ul></li>";
                }

                mysqli_free_result($result);
              ?>
            </ul>
          </td>
        </tr>
      </tbody>

    </table>

    <section class="buttonHolder">
      <button class="left inButton button" id="ajouter" onclick="checkAction('Add','ajouter_bac.php')">Add</button><br />
      <button class="left inButton button" id="modifier" onclick="checkAction('Alter','ajouter_bac.php')">Alter</button><br />
      <button class="left inButton button" id="supprimer" onclick="checkAction('Delete','ajouter_bac.php')">Delete</button><br />
      <button class="left inButton button" onclick="window.location.href='dashboard.php'">Ok</button><br />

    </section>

    </main>
    </section>
    <footer class="footer col-12 col-m-12 col-t-12 left">
  		<div>
  			&copy; Copyright 2019 ANNELIDA
  		</div>
  	</footer>

    <script src="JS/form_validation.js">

    </script>


  </body>
</html>

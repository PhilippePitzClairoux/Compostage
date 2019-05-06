
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
    //check if user is loged in
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");
    create_session();

    if (!check_if_valid_session_exists()) {
     header("Location: index.html");
     exit();
    }

    //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/ZoneManager.php")
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/RaspberryPiManager.php");
 ?>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Liste Zone</title>
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

  <h1>List of zones</h1>

    <table class="col-m-12 col-t-10 col-8 inTable left">

      <thead>
        <tr>
          <th class="inTableHead">
            Zone name
          </th>
          <th class="inTableHead">
            Zone Id
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="inTableElement" colspan="2">
            <ul class="left liste">
              <?php
                $result=fetchAllZones();

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
    </section>

    <section class="buttonHolder">
      <button class="left button inButton" id="ajouter" onclick="checkAction('Add','ajouter_zone.php')">Add</button><br />
      <button class="left button inButton" id="modifier" onclick="checkAction('Alter','ajouter_zone.php')">Alter</button><br />
      <button class="left button inButton" id="supprimer" onclick="checkAction('Delete','ajouter_zone.php')">Delete</button><br />
      <button class="left button inButton" onclick="window.location.href='dashboard.php'">Ok</button><br />
    </section>

    </main>

    <footer class="footer col-12 col-m-12 col-t-12 left">
  		<div>
  			&copy; Copyright 2019 ANNELIDA
  		</div>
  	</footer>

    <script src="JS/form_validation.js">

    </script>


  </body>
</html>

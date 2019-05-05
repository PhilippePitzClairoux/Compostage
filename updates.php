<!--********************************
    Fichier : updates.php
    Auteur : Philippe Pitz Clairoux
    Fonctionnalité :
    Date : 2019-05-04

    Vérification :
    Date                Nom                 Approuvé
    ====================================================

    Historique de modifications :
    Date                Nom                 Description
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

?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style.css" />
        <title>Create/Modify bed</title>
    </head>
    <body>

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

    <table>
        <thead>
            <tr>Update name</tr>
            <tr>Raspberry that completed it</tr>
            <tr>Date of the completion</tr>
        </thead>
    </table>


    <footer class="footer col-12 col-m-12 col-t-12 left">
        <div>
            &copy; Copyright 2019 ANNELIDA
        </div>
    </footer>
    <script src="JS/form_validation.js">

    </script>

    </body>
</html>

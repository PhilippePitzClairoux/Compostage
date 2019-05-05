<?php include_once("../controller/SessionUtils.php");
  create_session();

  if (!check_if_valid_session_exists()) {
      header("Location: login_page.html");
      exit();
  }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Welcome <?php echo $_SESSION["user"]->getUsername() ?></title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="JS/style.css">
    </head>
    <body onload="init()" class="col-10 col-m-12 col-t-12">

    <header class="col-12 col-m-12 col-t-12">
        <div>
            <img src="JS/logo.png">
        </div>

        <nav class="col-12 col-m-12 col-t-12">
            <ul class="col-12 col-m-12 col-t-12">
                <a href="dashboard.php"><li class="col-3 col-m-12 col-t-3 elementNav">Main</li></a>
                <a href=""><li class="col-3 col-m-12 col-t-3 elementNav">page2</li></a>
                <a href=""><li class="col-3 col-m-12 col-t-3 elementNav">page3</li></a>
                <a href="stats.html"><li class="col-3 col-m-12 col-t-3 elementNav">Stats</li></a>
            </ul>
        </nav>
    </header>
    <section class="col-12 col-m-12 col-t-12">
        <nav class="col-2 col-m-12 col-t-2 navigation">
            <ul class="col-12 col-m-12 col-t-12">
                <a href=""><li class="col-12 col-m-12 col-t-12 ">Account options</li></a>
                <a href="liste_bac.php"><li class="col-12 col-m-12 col-t-12 ">List of Bed</li></a>
                <a href="ajouter_bac.php"><li class="col-12 col-m-12 col-t-12 ">Add a Bed</li></a>
                <a href="liste_zone.php"><li class="col-12 col-m-12 col-t-12 ">List of Zone</li></a>
                <a href="ajouter_zone.php"><li class="col-12 col-m-12 col-t-12 ">Add a Zone</li></a>
                <a href="liste_rasp_pi.php"><li class="col-12 col-m-12 col-t-12 ">List of raspberry pi</li></a>
                <a href="ajouter_ras_pi.php"><li class="col-12 col-m-12 col-t-12 ">Add a rasberry pi</li></a>
                <a href="stats.html"><li class="col-12 col-m-12 col-t-12 ">Stats</li></a>
                <a href="../controller/LogoutManager.php"><li class="col-12 col-m-12 col-t-12 ">Disconnect</li></a>
            </ul>
        </nav>
    </section>

    <footer class="footer">
        <div>
            &copy; Copyright 2019 ANNELIDA
        </div>
    </footer>
    </body>
</html>
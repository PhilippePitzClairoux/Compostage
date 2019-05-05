<?php
    //check if user is loged in
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");
    create_session();

    if (!check_if_valid_session_exists()) {
        header("Location: index.html");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>page</title>
	<meta charset="utf-8">
	<script src="JS/chart_lib.js"></script>
	<script src="JS/chart_manipulator.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body onload="init()" class="col-10 col-m-12 col-t-12">

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

	<section class="col-12 col-m-12 col-t-12">

		<div class="col-5 chart col-m-12 col-t-5">
			<h1>Temperature</h1>
			<canvas id="chartTemp" height="50" width="100"></canvas>
		</div>

		<div class="col-5 chart chart col-m-12 col-t-5">
			<h1>Humidity</h1>
			<canvas id="chartHum" height="50" width="100"></canvas>
		</div>

		<div class="col-5 ph chart col-m-12 col-t-5">
			<h1>PH Level</h1>
			<canvas id="chartPh" height="50" width="100"></canvas>
		</div>
	</section>

	<footer class="footer">
		<div>
			&copy; Copyright 2019 ANNELIDA
		</div>
	</footer>
</body>
</html>

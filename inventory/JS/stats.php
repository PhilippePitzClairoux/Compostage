
<!DOCTYPE html>
<html>
<head>
	<title>page</title>
	<meta charset="utf-8">
	<script src="chart.js"></script>
	<script src="script.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body onload="init()" class="col-10 col-m-12 col-t-12">

	<header class="col-12 col-m-12 col-t-12">
		<div>
			<img src="logo.png">
		</div>

		<nav class="col-12 col-m-12 col-t-12">
			<ul class="col-12 col-m-12 col-t-12">
				<a href="dashboard.html"><li class="col-3 col-m-12 col-t-3 elementNav">Main</li></a>
				<a href=""><li class="col-3 col-m-12 col-t-3 elementNav">page2</li></a>
				<a href=""><li class="col-3 col-m-12 col-t-3 elementNav">page3</li></a>
				<a href="stats.html"><li class="col-3 col-m-12 col-t-3 elementNav">page4</li></a>
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
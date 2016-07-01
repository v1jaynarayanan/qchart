<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Survey Results</title>
	<link href='https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
</head>
<body>
	<header class="text-center"><img src="{{ URL::asset('images/logo.png') }}" alt="" width="180" /></header>
	<div class="container graph-container text-center">
		<h1>Survey Results</h1>
		<div id="chartHolder"><canvas id="myChart" width="440" height="440"></canvas><div id="legend"></div></div>
	</div>
	<script src="{{ URL::asset('js/build/production.min.js') }}"></script>
	<script>
		//radar chart data
		//console.log(<?php echo json_encode($datasets); ?>);
		var data = {
			
		    labels: <?php echo json_encode($labels); ?>,
		    datasets: <?php echo json_encode($datasets); ?>
		};
		var options = {
			responsive:true,
			scaleLineColor : "#abaeb2",
			pointLabelFontFamily : "tahoma",
			pointLabelFontSize:13,
			pointLabelFontColor:'#abaeb2'
        };
		//Create Radar chart
		var ctx = document.getElementById("myChart").getContext("2d");
		var myChart = new Chart(ctx).Radar(data, options);
		document.getElementById('legend').innerHTML = myChart.generateLegend();
	</script>
    <?php //print_r(json_encode($viewdata['datasets'])); ?>
</body>
</html>
@extends('layouts.app')

@section('content')
<body>
	<div class="container graph-container text-center">
		<h1>Survey Results</h1>
		<div id="chartHolder"><canvas id="myChart" width="440" height="440"></canvas><div id="legend"></div></div>
	</div>
	<script src="{{ URL::asset('js/build/production.min.js') }}"></script>
	<script>
		//radar chart data
		var data = {
			
		    labels: <?php echo json_encode($labels); ?>,
		    datasets: <?php echo json_encode($datasets); ?>
		};
		var options = {
			responsive:true,
			scaleLineColor : "#abaeb2",
			pointLabelFontFamily : "tahoma",
			pointLabelFontSize:13,
			pointLabelFontColor:'#abaeb2',
        };
		//Create Radar chart
		var ctx = document.getElementById("myChart").getContext("2d");
		var myChart = new Chart(ctx).Radar(data, options);
		document.getElementById('legend').innerHTML = myChart.generateLegend();
	</script>
</body>
@endsection
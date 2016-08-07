@extends('layouts.inner')

@section('content')
<body>
	<div class="container graph-container text-center">
		<h1>Survey Results</h1>
		<div id="chartHolder"><canvas id="myChart" width="640" height="640"></canvas>
		<div id="legend"></div></div>
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
			tooltipTemplate: "<%if (label){%><%=label %>: <%}%><%= value %>",
    		multiTooltipTemplate: "<%= value %>",
			legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li class=\"legend-item\" onclick=\"updateDataset($(this), window.myChart, '<%=datasets[i].label%>')\"><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
			scaleLineColor : "#abaeb2",
			pointLabelFontFamily : "tahoma",
			pointLabelFontSize:13,
			pointLabelFontColor:'#abaeb2',
        };

		//Create Radar chart
		var ctx = document.getElementById("myChart").getContext("2d");
		var myChart = new Chart(ctx).Radar(data, options);
		document.getElementById('legend').innerHTML = myChart.generateLegend();
		window.myChart.store = new Array();

	</script>
</body>
@endsection
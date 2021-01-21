<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reportes SIIGES</title>

	<!-- CSS GOB.MX -->
	<link href="../favicon.ico" rel="shortcut icon">
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">

	<!-- JS GRAFICOS -->
	<script src="http://www.chartjs.org/dist/2.7.2/Chart.bundle.js"></script>
	<script src="http://www.chartjs.org/samples/latest/utils.js"></script>

</head>

<body class="">
	<!-- CUERPO DEL FORMULARIO -->
	<div class="container">
		<section class="main row margin_section_formularios">

			<div class="col-md-9">
				<!-- <img src="../images/graficas.png" width="100%" > -->
				<div id="container" style="width: 75%;">
					<canvas id="canvas"></canvas>
				</div>
				<button id="randomizeData">Randomize Data</button>
				<button id="addDataset">Add Dataset</button>
				<button id="removeDataset">Remove Dataset</button>
				<button id="addData">Add Data</button>
				<button id="removeData">Remove Data</button>
				<script>
					var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
					var color = Chart.helpers.color;
					var horizontalBarChartData = {
						labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
						datasets: [{
							label: 'Dataset 1',
							backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
							borderColor: window.chartColors.red,
							borderWidth: 1,
							data: [
							randomScalingFactor(),
							randomScalingFactor(),
							randomScalingFactor(),
							randomScalingFactor(),
							randomScalingFactor(),
							randomScalingFactor(),
							randomScalingFactor()
							]
						}, {
							label: 'Dataset 2',
							backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
							borderColor: window.chartColors.blue,
							data: [
							randomScalingFactor(),
							randomScalingFactor(),
							randomScalingFactor(),
							randomScalingFactor(),
							randomScalingFactor(),
							randomScalingFactor(),
							randomScalingFactor()
							]
						}]

					};

					window.onload = function() {
						var ctx = document.getElementById('canvas').getContext('2d');
						window.myHorizontalBar = new Chart(ctx, {
							type: 'horizontalBar',
							data: horizontalBarChartData,
							options: {
					// Elements options apply to all of the options unless overridden in a dataset
					// In this case, we are setting the border of each horizontal bar to be 2px wide
					elements: {
						rectangle: {
							borderWidth: 2,
						}
					},
					responsive: true,
					legend: {
						position: 'right',
					},
					title: {
						display: true,
						text: 'Chart.js Horizontal Bar Chart'
					}
				}
			});

					};

					document.getElementById('randomizeData').addEventListener('click', function() {
						var zero = Math.random() < 0.2 ? true : false;
						horizontalBarChartData.datasets.forEach(function(dataset) {
							dataset.data = dataset.data.map(function() {
								return zero ? 0.0 : randomScalingFactor();
							});

						});
						window.myHorizontalBar.update();
					});

					var colorNames = Object.keys(window.chartColors);

					document.getElementById('addDataset').addEventListener('click', function() {
						var colorName = colorNames[horizontalBarChartData.datasets.length % colorNames.length];
						var dsColor = window.chartColors[colorName];
						var newDataset = {
							label: 'Dataset ' + horizontalBarChartData.datasets.length,
							backgroundColor: color(dsColor).alpha(0.5).rgbString(),
							borderColor: dsColor,
							data: []
						};

						for (var index = 0; index < horizontalBarChartData.labels.length; ++index) {
							newDataset.data.push(randomScalingFactor());
						}

						horizontalBarChartData.datasets.push(newDataset);
						window.myHorizontalBar.update();
					});

					document.getElementById('addData').addEventListener('click', function() {
						if (horizontalBarChartData.datasets.length > 0) {
							var month = MONTHS[horizontalBarChartData.labels.length % MONTHS.length];
							horizontalBarChartData.labels.push(month);

							for (var index = 0; index < horizontalBarChartData.datasets.length; ++index) {
								horizontalBarChartData.datasets[index].data.push(randomScalingFactor());
							}

							window.myHorizontalBar.update();
						}
					});

					document.getElementById('removeDataset').addEventListener('click', function() {
						horizontalBarChartData.datasets.splice(0, 1);
						window.myHorizontalBar.update();
					});

					document.getElementById('removeData').addEventListener('click', function() {
			horizontalBarChartData.labels.splice(-1, 1); // remove the label first

			horizontalBarChartData.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});

			window.myHorizontalBar.update();
		});
	</script>
	</div>
	</section>
</div>

	<!-- JS JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</body>
</html>

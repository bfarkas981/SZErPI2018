<!DOCTYPE html>
<?php
$limit=100;
$debug=0;
if (isset($_GET['limit'])) {
    $limit=$_GET['limit'];
}
if (isset($_GET['debug'])) {
    $debug=$_GET['debug'];
}
$conn = new mysqli('127.0.0.1','user1','');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Időjárás állomás</title>
	<script src="./js/Chart.bundle.js"></script>
	<style type="text/css">/* Chart.js */
@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style>
	<script src="./js/utils.js"></script>
	<style>
	canvas{
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
	<style>
		body { background-color: #EEEEEE }

		.GaugeMeter {
		position: Relative;
		text-align: Center;
		overflow: Hidden;
		cursor: Default;
		display: inline-block;
		}

		.GaugeMeter SPAN, .GaugeMeter B {
		width: 54%;
		position: Absolute;
		text-align: Center;
		display: Inline-Block;
		color: RGBa(0,0,0,.8);
		font-weight: 100;
		font-family: "Open Sans", Arial;
		overflow: Hidden;
		white-space: NoWrap;
		text-overflow: Ellipsis;
		margin: 0 23%;
		}

		.GaugeMeter[data-style="Semi"] B {
		width: 80%;
		margin: 0 10%;
		}

		.GaugeMeter S, .GaugeMeter U {
		text-decoration: None;
		font-size: .60em;
		font-weight: 200;
		opacity: .6;
		}

		.GaugeMeter B {
		color: #000;
		font-weight: 200;
		opacity: .8;
		}
		</style>
		<link href="css/jquerysctipttop.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
//$sql = "SELECT id, sender_id,mensuration_TS,temperature,humidity FROM db1.mensuration as m inner join (select sender_id as se, max(mensuration_TS) as ts from db1.mensuration group by sender_id) as l on m.sender_id=l.se and m.mensuration_TS=l.TS";
$sql = "SELECT id, sender_id,mensuration_TS,temperature,humidity FROM db1.mensuration order by mensuration_TS desc limit 1";
$result = $conn->query($sql);
//if (!$conn->query($sql)) {
  //  printf("Errormessage: %s\n", $conn->error);
//}
$lastTemperature=0;
$latHumidity=0;
$latmensuration_TS="";



if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "<H3>Állomás: ".$row["sender_id"]." | Hőmérséklet: ".$row["temperature"]."*C | Páratartalom: ".$row["humidity"]."% | Időpont: ".$row["mensuration_TS"]." </H3>";
		//echo "<H3>Hőmérséklet: ".$row["temperature"]."*C | Páratartalom: ".$row["humidity"]."% | Időpont: ".$row["mensuration_TS"]." </H3>";
		$lastTemperature=$row["temperature"];
		$latHumidity=$row["humidity"];
		$latmensuration_TS=$row["mensuration_TS"];
    }
} else {
    echo "0 results";
}
$sql = "select id, sender_id,mensuration_TS,temperature,humidity FROM ( SELECT id, sender_id,mensuration_TS,temperature,humidity FROM db1.mensuration order by id desc limit ".$limit." ) a order by mensuration_TS";
$result = $conn->query($sql);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}
//print json_encode($data);

?>
		<div class="container" style="margin:50px auto; text-align:center;">
		<H2 style="text-align: center;color:Black;">Időjárás állomás</H2>
        <br>
			<div class="GaugeMeter" id="PreviewGaugeMeter_4" data-percent=<?php echo $lastTemperature ?> data-append="*C" data-size="200" data-theme="Black" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="Hőmérséklet" data-label_color="#000" data-style="Semi" data-stripe="2"></div>
			<div class="GaugeMeter" id="PreviewGaugeMeter_2" data-percent=<?php echo $latHumidity ?> data-append="%" data-size="200" data-theme="Black" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="Páratartalom" data-label_color="#000" data-style="Semi" data-stripe="2"></div>
			<br>
			<span style="text-align: center;color:Black;"><?php echo $latmensuration_TS ?></span>		
		</div>
		<script src="js/jquery-2.1.4.min.js"></script> 
		<script src="js/jquery.AshAlom.gaugeMeter-2.0.0.min.js"></script> 
		<script>
		$(".GaugeMeter").gaugeMeter();
		</script>

     <div style="text-align: center;">
     	
            
            

            
            
            
            <br>
        </div>
	<div style="width:75%;margin: auto;">
            <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                </div>
            <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
		<canvas id="canvas" width="832" height="416" class="chartjs-render-monitor" style="display: block; width: 832px; height: 416px;"></canvas>
	</div>
	
	<br>
	<script>
                var data = <?php echo json_encode($data); ?>;
                var _labels = [];
		var temperatures = [];
		var humidity = [];
		for(var i in data) {
				_labels.push(data[i].mensuration_TS);
				temperatures.push(data[i].temperature);
                                humidity.push(data[i].humidity);
			}
		
		var config = {
			type: 'line',
			data: {
				labels: _labels,
				datasets: [{
					label: 'Hőmérséklet',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: temperatures,
					fill: false,
				}, {
					label: 'Páratartalom',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: humidity,
				}]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Korábban mért értékek'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Időpont'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Hőmérséklet / Páratartalom'
						}
					}]
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};

	</script>

 <div style="text-align: center;">

<?php
if ($debug==1)
{
	$sql = "SELECT id, sender_id,mensuration_TS,temperature,humidity FROM db1.mensuration order by id desc limit ".$limit;
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//echo "id: " . $row["id"]." sender: " . $row["sender_id"]." DateTime: " . $row["mensuration_TS"]." temperature: " . $row["temperature"]." humidity: " . $row["humidity"]. "<br>";
			echo "id: " . $row["id"]." DateTime: " . $row["mensuration_TS"]." temperature: " . $row["temperature"]." humidity: " . $row["humidity"]. "<br>";
		}
	} else {
		echo "0 results";
	}
}
$conn->close();
    



?>
</div>
</body></html>



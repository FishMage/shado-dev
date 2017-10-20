<?php

	session_start();
	$traff_levels = [0.5 => 0.1, 1 => 1, 2 => 2];

	$file = fopen($_SESSION['session_dir'] . "input_summary.txt", "w");
	fwrite($file,"time,");
	fwrite($file,"t_level\n");
	for ($i = 0; $i < $_SESSION['parameters']['hours']; $i++) {
		fwrite($file,($i) .",");
		$label = $_SESSION['parameters']['traffic_nums'][$i];
		fwrite($file, $traff_levels[$label]."\n");
	}
	fwrite($file,($time) .",");
	fwrite($file,"0\n");

	fclose($file);
?>

<!DOCTYPE html>
<meta charset="utf-8">
<style>

#input{
	padding:5px 15px;
	width:fit-content;
	width:-webkit-fit-content;
	width:-moz-fit-content;
	border: 3px solid #5D7B85;
	cursor:pointer;
	-webkit-border-radius: 5px;
	border-radius: 25px;
	display: inline-block;
	margin: 50px;
	text-align: left;
	background-color: rgba(255, 255, 255, 0.6);
}

.bar:hover {
  fill: brown;
}

.axis {
  font: 10px sans-serif;
}

.y.axis{
	font: 13px sans-serif;
}

.x.axis{
	font: 15px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.x.axis path {
  display: none;
}

</style>
<div class= 'operatorSummaryOuter'>
<div id="input">
	<h3 style="text-align: center;"> <u>Trip Conditions:</u></h3>
	<ul>
	<li><em>Trip Duration:</em> <?php echo $_SESSION['parameters']['hours'] . " hours"; ?></li>
	<br>
	<li><em>Traffic Levels:</em></li>
	<div id="input_summary" class="no-page-break"></div>
	<br>
	<li><em>Assistants Supporting the Engineer:</em><ul>
	<?php
		$found = false;

		foreach ($_SESSION['parameters']['assistants'] as $assistant) {
			if ($assistant != 'engineer') {
				echo "<li>". ucwords($assistant)."</li>";
				$found = true;
			}
		}
		if(!$found){
			echo "<li>None</li>";
		}
	?>
	</ul></li>
	</ul>
</div>
</div>

<script src="//d3js.org/d3.v3.min.js"></script>
<script>

var temp= <?php echo $_SESSION['parameters']['hours']; ?>;

var margin = {top: 20, right: 50, bottom: 45, left: 50},
    width = 300,
    height = 300 - margin.top - margin.bottom;

var x_input = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .rangeRound([height, 0]);

var xAxis_input = d3.svg.axis()
    .scale(x_input)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
	.ticks(3);
	// .tickFormat('[1], m, h');

d3.select('svg')
  .append('g')
  .attr('transform', 'translate(180, 10)')
  .call(yAxis)
  .selectAll('text') // `text` has already been created
  .selectAll('tspan')
  .data(function (d) { return bytesToString(d); }) // Returns two vals
  .enter()
  .append('tspan')
  .attr('x', 0)
  .attr('dx', '-1em')
  .attr('dy', function (d, i) { return (2 * i - 1) + 'em'; })
  .text(String);

var ticks_gap1=1;
if(temp>8){
	ticks_gap1=2;
}

xAxis_input.tickFormat(function (d,counter=0) {if(counter%ticks_gap1==0){counter++; return d;} });
// yAxis_input.tickFormat(function(d, i) {return d;});

var svg_summary = d3.select("#input_summary").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

// d3.csv("sessions/input_summary.txt", type, function(error, data) {
// d3.csv('<?php echo $_SESSION['session_dir'] . "input_summary.txt"; ?>', type, function(error, data) {
d3.csv("read_file.php?filename=input_summary.txt", type, function(error, data) {

  if (error) throw error;

  x_input.domain(data.map(function(d) { return d.time; }));

  y.domain([0,2.5]);

  svg_summary.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate("+(-width/(2*temp)+24/temp)+"," + (height-185) + ")")
      .call(xAxis_input)
	  .append("text")
	  .attr("transform", "translate("+((width / 2)-30)+",40)" )
	  .attr("x", 1)
	  .attr("dx", ".71em")
	  .text("Time (hour)");

  svg_summary.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    	.append("text")
		.attr("transform", "translate(-50,265) rotate(-90)" )
		.attr("y", 6)
		.attr("dy", ".71em")
		.text("Traffic Level (0 = Low, 1 = Med, 2 = High)");

  svg_summary.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
	  .attr("fill",function(d,i){console.log(d.t_level); if(d.t_level==1){return "blue";}  if(d.t_level==2){return "blue";}  if(d.t_level==3){return "blue";} })
      .attr("x", function(d) { return x_input(d.time); })
      .attr("width", x_input.rangeBand())
      .attr("y", function(d) { return y(d.t_level); })
      .attr("height", function(d) { return height - y(d.t_level)-185; });
});

function type(d) {
  d.t_level = +d.t_level;
  return d;
}
</script>

// $(document).ready(function() {
// 	d3_visual();
// });
// alert('Here');

function d3_visual(assistant, num, filename) {
	console.log("started d3 visual");
	var legend_width = 120;

	var temp=num;

	var margin = {top: 30, right: 130, bottom: 50, left: 70},
	    width = 800;

	    height = 500 - margin.top - margin.bottom;

	var x = d3.scale.ordinal()
	    .rangeRoundBands([0, width],0.4);

	var yAbsolute = d3.scale.linear() // for absolute scale
	    .rangeRound([height, 0]);
	var yRelative = d3.scale.linear() // for absolute scale
		    .rangeRound([height, 0]);
	var color = d3.scale.category20();
	// var color = d3.scale.ordinal()
	    // .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00", "#dd843c", "#ff8ff0"]);

	var xAxis = d3.svg.axis()
	    .scale(x)
	    .orient("bottom");

	var ticks_gap=Math.round((temp-2)/12);

	xAxis.tickFormat(function (d,counter=0) {if(counter%ticks_gap==0){counter++; return d;} });

	var yAxisRelative = d3.svg.axis()
	    .scale(yRelative)
	    .orient("left");

	var yAxisAbsolute = d3.svg.axis()
		    .scale(yAbsolute)
		    .orient("left");

	var div = d3.select("#graph_" + assistant).append("div")
	    .attr("class", "tooltip")
	    .style("opacity", 0);

	var svg_eng = d3.select("#graph_" + assistant).append("svg")
	    .attr("width", width + margin.left + margin.right+legend_width)
	    .attr("height", height + margin.top + margin.bottom)
	  .append("g")
	    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	console.log("read_file.php?filename=" + filename);
	d3.csv("read_file.php?filename=" + filename, function(error, data) {
	  color.domain(d3.keys(data[0]).filter(function(key) { return key !== "time"; }));

	  data.forEach(function(d) {
		//  	console.log(d);
		var index=d.time.indexOf('min');
		var mystate = d.time.slice(0,index);
		// console.log(mystate);

	    var y0 = 0;

		d.ages = color.domain().map(function(name) { return { mystate:mystate, name: name, y0: y0, y1: y0 += +d[name]}; });

	    d.total = d.ages[d.ages.length - 1].y1;// the last row

		d.pct = [];
		d.total=d.total*100;

		for (var i=0;i <d.ages.length;i ++ ){
			d.ages[i].y1=d.ages[i].y1*100;
			d.ages[i].y0=d.ages[i].y0*100;
			d.ages[i].total=d.total;
		}
		for (var i=0;i <d.ages.length;i ++ ){

			var y_coordinate = +d.ages[i].y1/d.total;
		    var y_height1 = (d.ages[i].y1)/d.total;
			var y_height0 = (d.ages[i].y0)/d.total;
			var y_pct = y_height1 - y_height0;
			d.pct.push({
				y_coordinate: y_coordinate,
				y_height1: y_height1,
				y_height0: y_height0,
				name: d.ages[i].name,
				mystate: d.time.slice(0,index),
				y_pct: y_pct
			});
		}
	  });

	  x.domain(data.map(function(d) {var index=d.time.indexOf('min');	 return d.time.slice(0,index); }));

	  yAbsolute.domain([0,100]);//Absolute View scale
	  yRelative.domain([0,100])// Relative View domain

	  var absoluteView = true // define a boolean variable, true is absolute view, false is relative view
	  						  // Initial view is absolute
	  svg_eng.append("g")
	      .attr("class", "x axis")
	      .attr("transform", "translate("+(-width/(2*temp))+"," + height +")")
		  .call(xAxis)
		  .append("text")
		  .attr("transform", "translate("+(width / 2)+",45)" )
		  .attr("x", 1)
		  .attr("dx", ".71em")
		  .text("Time (min)");

		var stateAbsolute= svg_eng.selectAll(".absolute")
							.data(data)
			    			.enter().append("g")
			    			.attr("class", "absolute")
			   			 .attr("transform", function(d) { return "translate(0,0)"; });

		stateAbsolute.selectAll("rect")
				    .data(function(d) { return d.ages})
				    .enter().append("rect")
				    .attr("width", x.rangeBand())
				    .attr("y", function(d) {

						  return yAbsolute(d.y1);
					})
				    .attr("x",function(d) {
						  return x(d.mystate)
					})
				    .attr("height", function(d) {
						  return yAbsolute(d.y0) - yAbsolute(d.y1);
						  })
				    .attr("fill", function(d){
						  return color(d.name)
						  })
					.attr("id",function(d) {
						  return d.mystate
					})
					.attr("class","absolute")
					.style("pointer-events","all");
					 // initially it is invisible, i.e. start with Absolute View

		stateAbsolute.selectAll("rect")
			.on("mouseover", function(d){
				// console.log(d);

				var xPos = parseFloat(d3.select(this).attr("x"));
				var yPos = parseFloat(d3.select(this).attr("y"));
				var height = parseFloat(d3.select(this).attr("height"))

				d3.select(this).attr("stroke","blue").attr("stroke-width",0.8);
				div.transition()
	                .duration(200)
	                .style("opacity", .9);
	            div	.html("Task: " + d.name + "<br> Mean Utilization: "+(d.y1-d.y0).toFixed(2) + "%<br> Total Utilization: "+d.total.toFixed(2) + "%")
	                .style("left", (d3.event.pageX+20) + "px")
	                .style("top", (d3.event.pageY - 20) + "px");

			})
			.on("mouseout", function(d) {

				d3.select(this).attr("stroke","pink").attr("stroke-width",0.2);
	            div.transition()
	                .duration(100)
	                .style("opacity", 0);
			})
		//define two different scales, but one of them will always be hidden.
		svg_eng.append("g")
			.attr("class", "y axis absolute")
			.call(yAxisAbsolute)
			.append("text")

			.attr("transform", "translate(-60,"+(height/2)+") rotate(-90)" )

			.attr("y", 6)
			.attr("dy", ".71em")
			.style("text-anchor", "end")
			.text("Utilization (%)");

		// svg_eng.append("foreignObject")
		// 		.attr("x", ((width / 2)+110))
		// 		.attr("y", -12 - (margin.top / 2))
		// 		.attr("text-anchor", "middle")
		// 		.style("font-size", "24px")
		// 		.html("<span class='tooltip' onmouseover='tooltip.pop(this, &apos; Hover over the graph for more information &apos;)'><sup>(?)</sup></span>");

		svg_eng.append("text")
	        .attr("x", (width / 2))
	        .attr("y", 10 - (margin.top / 2))
	        .attr("text-anchor", "middle")
	        .style("font-size", "24px")
	        .style("text-decoration", "underline")
	        .text(assistant + " Workload");

		// end of define absolute

		// adding legend

	  	    var legend = svg_eng.selectAll(".legend")
	      	 	 			.data(color.domain().slice().reverse())
	    	 			    .enter().append("g")
	    				    	.attr("class", "legend")
	    	 			    	.attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });
	 		 legend.append("rect")
	   	   			.attr("x", width)
	    			.attr("width", 18)
	     	    	.attr("height", 18)
	     	    	.attr("fill", color);
	 		 legend.append("text")
	      		.attr("x", width+25)
	     	    .attr("y", 9)
	      	    .attr("dy", ".35em")
	      	    .style("text-anchor", "start")
	     	    .text(function(d) { return d; });
	});

	console.log("DONE!");
}

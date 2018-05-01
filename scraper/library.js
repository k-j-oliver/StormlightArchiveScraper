// library for scraper's javascript
// includes d3 bar chart

var ajax = getAjaxObject();
if (ajax) {
	console.log("You've got ajax");
} 

document.getElementById('viz').addEventListener('click', doAjax, false);

function getAjaxObject() {
	var obj;
	if(window.XMLHttpRequest) {
		obj = new XMLHttpRequest();
	} else {
		obj = new ActiveXObject('Microsoft.XMLHTTP');
	}
	return obj;
}

function doAjax() {
	// Collect data from <input> element:
	var values = document.getElementById('viz');
		for (var i = 0, length = values.length; i < length; i++) {
	 		if (values[i].checked) {
		  		value = (values[i].value);
		  		console.log(value);
		  		break;
	 		}
		}

	url = "http://hucodev.artsrn.ualberta.ca/oliver2/scraper/getData.php?viz=" + value;

	// Tell Ajax to open a new connection to the server:
	ajax.open("GET", url, true);

	// Tell Ajax to send the request
	ajax.send();

	if (value == 'book') {
		// clear section#graph before rendering graph.
		var target = document.getElementById('graphs');
		target.innerHTML = ''; 
		showBookGraph();
	}

	if (value == 'status') {
		// clear section#graph before rendering graph.
		var target = document.getElementById('graphs');
		target.innerHTML = ''; 
		showStatusGraph();
	}

	if (value == 'gender') {
		// clear section#graph before rendering graph.
		var target = document.getElementById('graphs');
		target.innerHTML = ''; 
		showGenderGraph('gender');
	}
}

////////////////////////////////////////////////////////////////////
//
//	Following code from http://bl.ocks.org/Jverma/887877fc5c2c2d99be10
// 	Some modifications to canvas size, axis labels, and colour (2018-04-20).
//	Designs each bar graph separately. Not ideal.
//
///////////////////////////////////////////////////////////////////

function showGenderGraph() {
	// set the dimensions of the canvas
	var margin = {top: 20, right: 20, bottom: 180, left: 60},
	    width = 400 - margin.left - margin.right,
	    height = 500 - margin.top - margin.bottom;

	// set the ranges
	var x = d3.scale.ordinal().rangeRoundBands([0, width], .05);

	var y = d3.scale.linear().range([height, 0]);

	// define the axis
	var xAxis = d3.svg.axis()
	    .scale(x)
	    .orient("bottom")

	var yAxis = d3.svg.axis()
	    .scale(y)
	    .orient("left")
	    .ticks(10);

	// add the SVG element
	var svg = d3.select("section#graphs").append("svg")
	    .attr("width", width + margin.left + margin.right)
	    .attr("height", height + margin.top + margin.bottom)
	  .append("g")
	    .attr("transform", 
	          "translate(" + margin.left + "," + margin.top + ")");

	// load the data
	d3.json("gender.json", function(error, data) {
	    data.forEach(function(d) {
	        d.gender = d.gender;
	        d.NumberOfCharacters = +d.NumberOfCharacters;
	    });
	    console.log(data);
		
	  // scale the range of the data
	  x.domain(data.map(function(d) { return d.gender; }));
	  y.domain([0, d3.max(data, function(d) { return d.NumberOfCharacters; })]);

	  // add axis
	  svg.append("g")
	      .attr("class", "x axis")
	      .attr("transform", "translate(0," + height + ")")
	      .call(xAxis)
	    .selectAll("text")
	      .style("text-anchor", "end")
	      .attr("dx", "-.8em")
	      .attr("dy", "-.55em")
	      .attr("transform", "rotate(-65)" );

	  svg.append("g")
	      .attr("class", "y axis")
	      .call(yAxis)
	    .append("text")
	      .attr("transform", "rotate(-90)")
	      .attr("y", 20 - margin.left)
	      .attr("dy", ".71em")
	      .style("text-anchor", "end")
	      .text("NumberOfCharacters");

	  // Add bar chart
	  svg.selectAll("bar")
	      .data(data)
	    .enter().append("rect")
	      .attr("class", "bar")
	      .attr("x", function(d) { return x(d.gender); })
	      .attr("width", x.rangeBand())
	      .attr("y", function(d) { return y(d.NumberOfCharacters); })
	      .attr("height", function(d) { return height - y(d.NumberOfCharacters); });
	});
}

function showStatusGraph() {
	// set the dimensions of the canvas
	var margin = {top: 20, right: 20, bottom: 180, left: 60},
	    width = 400 - margin.left - margin.right,
	    height = 500 - margin.top - margin.bottom;

	// set the ranges
	var x = d3.scale.ordinal().rangeRoundBands([0, width], .05);

	var y = d3.scale.linear().range([height, 0]);

	// define the axis
	var xAxis = d3.svg.axis()
	    .scale(x)
	    .orient("bottom")

	var yAxis = d3.svg.axis()
	    .scale(y)
	    .orient("left")
	    .ticks(10);

	// add the SVG element
	var svg = d3.select("section#graphs").append("svg")
	    .attr("width", width + margin.left + margin.right)
	    .attr("height", height + margin.top + margin.bottom)
	  .append("g")
	    .attr("transform", 
	          "translate(" + margin.left + "," + margin.top + ")");

	// load the data
	d3.json("status.json", function(error, data) {

	    data.forEach(function(d) {
	        d.status = d.status;
	        d.NumberOfCharacters = +d.NumberOfCharacters;
	    });
	    console.log(data);

	  // scale the range of the data
	  x.domain(data.map(function(d) { return d.status; }));
	  y.domain([0, d3.max(data, function(d) { return d.NumberOfCharacters; })]);

	  // add axis
	  svg.append("g")
	      .attr("class", "x axis")
	      .attr("transform", "translate(0," + height + ")")
	      .call(xAxis)
	    .selectAll("text")
	      .style("text-anchor", "end")
	      .attr("dx", "-.8em")
	      .attr("dy", "-.55em")
	      .attr("transform", "rotate(-65)" );

	  svg.append("g")
	      .attr("class", "y axis")
	      .call(yAxis)
	    .append("text")
	      .attr("transform", "rotate(-90)")
	      .attr("y", 20 - margin.left)
	      .attr("dy", ".71em")
	      .style("text-anchor", "end")
	      .text("NumberOfCharacters");

	  // Add bar chart
	  svg.selectAll("bar")
	      .data(data)
	    .enter().append("g")
	  	  .append("rect")
	      .attr("class", "bar")
	      .attr("x", function(d) { return x(d.status); })
	      .attr("width", x.rangeBand())
	      .attr("y", function(d) { return y(d.NumberOfCharacters); })
	      .attr("height", function(d) { return height - y(d.NumberOfCharacters); });

	});
}

function showBookGraph() {
	// set the dimensions of the canvas
	var margin = {top: 20, right: 20, bottom: 180, left: 60},
	    width = 600 - margin.left - margin.right,
	    height = 500 - margin.top - margin.bottom;

	// set the ranges
	var x = d3.scale.ordinal().rangeRoundBands([0, width], .05);

	var y = d3.scale.linear().range([height, 0]);

	// define the axis
	var xAxis = d3.svg.axis()
	    .scale(x)
	    .orient("bottom")

	var yAxis = d3.svg.axis()
	    .scale(y)
	    .orient("left")
	    .ticks(10);

	// add the SVG element
	var svg = d3.select("section#graphs").append("svg")
	    .attr("width", width + margin.left + margin.right)
	    .attr("height", height + margin.top + margin.bottom)
	  .append("g")
	    .attr("transform", 
	          "translate(" + margin.left + "," + margin.top + ")");


	// load the data
	d3.json("book.json", function(error, data) {

	    data.forEach(function(d) {
	        d.book = d.book;
	        d.NumberOfCharacters = +d.NumberOfCharacters;
	    });
		console.log(data);

	  // scale the range of the data
	  x.domain(data.map(function(d) { return d.book; }));
	  y.domain([0, d3.max(data, function(d) { return d.NumberOfCharacters; })]);

	  // add axis
	  svg.append("g")
	      .attr("class", "x axis")
	      .attr("transform", "translate(0," + height + ")")
	      .call(xAxis)
	    .selectAll("text")
	      .style("text-anchor", "end")
	      .attr("dx", "-.8em")
	      .attr("dy", "-.55em")
	      .attr("transform", "rotate(-65)" );

	  svg.append("g")
	      .attr("class", "y axis")
	      .call(yAxis)
	    .append("text")
	      .attr("transform", "rotate(-90)")
	      .attr("y", 20 - margin.left)
	      .attr("dy", ".71em")
	      .style("text-anchor", "end")
	      .text("NumberOfCharacters");

	  // Add bar chart
	  svg.selectAll("bar")
	      .data(data)
	    .enter().append("rect")
	      .attr("class", "bar")
	      .attr("x", function(d) { return x(d.book); })
	      .attr("width", x.rangeBand())
	      .attr("y", function(d) { return y(d.NumberOfCharacters); })
	      .attr("height", function(d) { return height - y(d.NumberOfCharacters); });

	});

}
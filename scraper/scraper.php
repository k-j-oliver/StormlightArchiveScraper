<!DOCTYPE html>
<html lang=en>

<head>
	<meta charset=utf-8>
	<title>Stormlight Archive Characters</title>

	<style>
		#sidebar{
			float:right;
		}
		.bar{
	    	fill: #268723;
	  	}

	  	.bar:hover{
	    	fill: #92b28d;
	  	}

		.axis {
		  	font: 10px sans-serif;
		}

		.axis path,
		.axis line {
		  	fill: none;
		  	stroke: #000;
		  	shape-rendering: crispEdges;
		}
	</style>

</head>

<body>
	<h2>Stormlight Archive Characters</h2>
	<p>
		<a href="https://github.com/k-j-oliver/StormlightArchiveScraper" target="_blank">GitHub repository</a>
	</p>

	<p>
		<h3>About these visualizations</h3>
		The data for these visualizations are scraped from <a href="http://stormlightarchive.wikia.com/wiki/Category:Characters" target="_blank">the Stormlight Archive wiki</a>, and are meant to show some facet of the community involvement in the fan-made wiki. <br><br>
		NULLs and Unknowns are included to show level of participation. In the case of the book chart, the NULL value distorted the information (~300) and is left out. <br><br>
	</p>
	<section id="sidebar">
		<p>
			<h4>FYI:</h4>
			NULL = Information that was left blank by the participant.<br>
			Unknown = Intentionally filled in by participant.<br>
		</p>
	</section>
	<p>
		Show me...
	</p>

	<form id="viz" method="get" action="scraper.php">
		<section class="radio">
			<p>		
				<input type="radio" id="viz" name="viz" value="gender"> The gender breakdown<br>
				<input type="radio" id="viz" name="viz" value="status"> How many characters have died<br>
				<input type="radio" id="viz" name="viz" value="book"> How many characters are in each book<br><br>
			</p>
		</section>
	</form>
	<section id="graphs"></section>

</body>

<script type=text/javascript src=library.js></script>
<script src="https://d3js.org/d3.v3.min.js"></script>

</html>
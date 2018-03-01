<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php if (isset($page_title)) echo $page_title; else echo 'SHADO';?></title>
		<link rel="stylesheet" type="text/css" href="styles/global_styles.css.php">
		<!-- <link rel="stylesheet" type="text/css" href="tooltips/tooltip.css"> -->
		<link rel="stylesheet" type="text/css" href="tooltips/new_tooltip.css">

<!--        Richard Chen 9/22 Edit: added Pure framework-->
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<!-- <script type="text/javascript" src="tooltips/tooltip.js"></script> -->
		<script type="text/javascript" src="scripts/graph_navBar.js"></script>
		<script type="text/javascript" src="scripts/nav_selections.js"></script>
		<?php if (isset($html_head_insertions)) echo $html_head_insertions;?>
	</head>
	<body>
		<div id="fixedHead">
			<div id="title">
				<a href="http://hal.pratt.duke.edu">
                    <img id ="underConstruction"src="images/under-construction.png"style="width:80px;height:80px;">
					<img id="halLogo" src="images/hal_light.png">

				</a>
				<h1 style="padding: 40px 290px; font-size: 25; font-family: 'Lucida Grande'">Simulator of Human and Automation in Dispatch Operations</h1>

			</div>

			<nav id="topNav" class="hide"style="font-family: 'Lucida Grande'">
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="basic_settings.php">Run Simulation</a></li>
					<li><a href="contact_us.php">Contact Us</a></li>
					<li style="float: right"><a href="version_history.php">Version</a></li>
				</ul>
			</nav>
		</div>

		<div id="fixedBody"></div>
		<div id="main">
			<input id="assistant_info" value="<?php echo $_SESSION['session_results'] + in_array('conductor', $_SESSION['parameters']['assistants']);?>" type="hidden">

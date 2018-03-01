<?php
    error_reporting(0);
	require_once('includes/session_management/init.php');
	$html_head_insertions = '<script src="http://d3js.org/d3.v3.min.js"></script>' . "\r\n\t\t";
	$html_head_insertions .= '<script type="text/javascript" src="includes/results/d3_graph.js"></script>';
	$page_title = 'Detailed Analysis';
	require_once('includes/page_parts/header.php');
	require_once('includes/page_parts/side_navigation.php');
	require_once('includes/results/graph_navBar_calculations.php');
	// require_once('includes/results/d3_graph.php');
	require_once('includes/results/graph_CsvFile.php');
	echo "<div id='page' class='page'>";

	// Get the specific data from operator called

	if ($_GET['operator'] == 'conductor') {
		$assistant = "conductor";
		require_once('includes/results/d3_graph.php');
		createGraphCsv('conductor');
		graphText($_SESSION['session_dir'] . 'conductor.csv');
		echo "</div>";
	} else if ($_GET['operator'] == 'engineer') {
		$assistant = "Engineer";
		require_once('includes/results/d3_graph.php');
		createGraphCsv('engineer');
		graphText($_SESSION['session_dir'] . 'engineer.csv');
		echo "</div>";

	} else if ($_GET['operator'] == 'dispatcher') {
        $assistant = "Dispatcher";
        require_once('includes/results/d3_graph.php');
        createGraphCsv('dispatcher');
        graphText($_SESSION['session_dir'] . 'dispatcher.csv');
        echo "</div>";
    } else {
		die('There was an error');
	}

?>
	<div id="bottomNav">
		<ul>
			<li>
				<button class="button" type="button" onclick="location.href='view_results.php';" style="color: black">&#8678 Results</button>
			</li>
			<li>
				<button type="button" class="button" onclick="location.href='sim_summary.php';" style="color: black; visibility: hidden;">Print Report</button>
			</li>
			<li>
				<button type="button" class="button" onclick="location.href='sim_summary.php';" style="color: black;">Preview Report &#8680</button>
			</li>
		</ul>
	</div>

<?php
	require_once('includes/page_parts/footer.php');
?>

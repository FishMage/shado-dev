<?php
/****************************************************************************
*																			*
*	File:		view_results.php 											*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This file sets the results page.							*
*																			*
****************************************************************************/

//	Initialize session
    error_reporting(0);
	require_once('includes/session_management/init.php');

//	Include headers

	$page_title = 'Results';
	require_once('includes/results/read_csv.php');
	require_once('includes/page_parts/header.php');
	require_once('includes/page_parts/side_navigation.php');
	require_once('operator_calculations.php');
	require_once('operator.html');

?>
			<br><br><br>
		</div>

		<div id="bottomNav" style="padding-left: 200px;">
			<ul>
				<!-- <li>
					<button type="button" class="button remove" onclick="location.href='sim_summary.php';" style="color: black">Print Report</button>
				</li> -->
				<li>
					<button class="pure-button" type="button" onclick="location.href='basic_settings.php';" style="color: black;  box-shadow: 0px 8px 8px 0px rgba(0,0,0,0.2);">&#8678 Change Inputs</button>
				</li>
				<!-- <li>
					<button type="button" class="button hide remove" onclick="location.href='investigate.php?operator=engineer';" style="color: black;">Detailed Results &#8680</button>
				</li> -->
			</ul>
		</div>

<?php require_once('includes/page_parts/footer.php'); ?>

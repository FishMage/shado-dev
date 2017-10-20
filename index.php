<?php
/****************************************************************************
*																			*
*	File:		index.php  													*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This file sets the homepage.								*
*																			*
****************************************************************************/

//	Initialize session

	include('includes/session_management/init.php');

//	Reset session, for testing purposes

//	session_unset();
//	include('includes/session_management/set_session_vars.php');

//	Include page header

	$page_title = 'SHADO';
	require_once('includes/page_parts/header.php');
	// print_r($_SESSION);
?>

			<div id="homePage" class="page" style="font-family: 'Lucida Grande'">
				<h1 class="pageTitle" style="font-family: 'Lucida Grande'">Welcome to the SHADO!</h1>

                <div class="stepBox">
                    <h2 style="font-family: 'Lucida Grande'">Introduction</h2>
                    <p>Welcome to the <u>S</u>imulator of <u>H</u>umans and <u>A</u>utomation in <u>D</u>ispatch <u>O</u>perations (SHADO)! This tool, designed by Duke University researchers, simulates the workload of a dispatch operator and associated freight rail operators across the duration of a given shift. With SHADO, you can choose a trip with unique conditions and then see the operators' average workload after thousands of similar shifts.</p>
                </div>
                <br>
                <div class="stepBox">
                    <p>
<!--->
					You should use this tool to answer the following questions:
					<ul style="margin-top: -15px;">
						<li><em>When</em> are my operators over or under-utilized at work?</li>
						<li><em>Why</em> are my operators over or under-utilized at work?</li>
						<li><em>How</em> might we improve operator workload, as well as overall system efficiency and safety?</li>
					</ul>
				    </p>
                </div>
                <br>
                <div class="stepBox" >
				<h2 style="font-family: 'Lucida Grande'">Background</h2>
<!--				<p>-->
					A core set of tasks has been defined and implemented to encompass tasks that crew members may encounter during their trip. These tasks and their descriptions are summarized below. To see more underlying assumptions, visit advanced settings.
					<table class="pure-table" align="center" width=auto style="margin-top: 30px; margin-right: 30px; font-family: 'Lucida Grande'; font-size: small">
					    <tr>
					        <th>Task Type</th>
					        <th>Description</th>
					    </tr>
						<?php
							$task_names = array_keys($_SESSION['default_tasks']);
							foreach ($task_names as $task) {
								echo '<tr>';
								echo '<td>' . ucwords($task) . '</td>';
								echo '<td>' . $_SESSION['default_tasks'][$task]['description'] . '</td>';
								echo '</tr>';
							}
						?>
					</table>
<!--				</p>-->
                </div>
                <br>
                <div class="stepBox">
				<h2 style="font-family: 'Lucida Grande'">Getting Started</h2>
				<p>
					 Note that this site is currently only compatible with Chrome and Firefox. If you're ready to get started, then let's <a href="basic_settings.php">go</a>! And if you encounter any issues or have questions about the simulation, please <a href="contact_us.php">contact us</a>!
				</p>
			    </div>
            </div>
			<footer style='text-align: center; padding: 20px 0; font-size: 18;'>
				<strong>NOTE: </strong>This decision support tool is intended to inform rather than dictate decisions.
			</footer>
<?php require_once('includes/page_parts/footer.php');?>

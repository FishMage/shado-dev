<?php
/****************************************************************************
*																			*
*	File:		version_history.php  										*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This file sets the version history page.					*
*																			*
****************************************************************************/

//	Initialize session

	require_once('includes/session_management/init.php');

//	Include page header

	$page_title = 'Current Version';
	require_once('includes/page_parts/header.php');
?>
			<div id="versionPage" class="page">
				<h1 class="pageTitle">Release Notes</h1>
				<h2 style="margin:0; padding:10px 0;">Version Beta</h2>
				<h3 style="margin:0; padding:0;">Released 9/26/17</h3>
				<ul>
					<li>Input number of dispatchers, number of trains, begin time, end time, traffic levels, and assistants.</li>
					<li>Change the underlying task and model assumptions.</li>
					<li>View summarized results, detailing the relative workloads.</li>
					<li>View a utilization graph for each human operator selected.</li>
					<li>Print a summary of results.</li>
				</ul>
			</div>
<?php require_once('includes/page_parts/footer.php');?>

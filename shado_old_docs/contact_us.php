<?php
/****************************************************************************
*																			*
*	File:		contact_us.php  											*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This file sets the contact us page.							*
*																			*
****************************************************************************/

//	Initialize session

	require_once('includes/session_management/init.php');

//	Include page header

	$page_title = 'Contact Us';
	require_once('includes/page_parts/header.php');
?>
			<div id="contactPage" class="page">
				<h1 class="pageTitle">Contact Us</h1>
				<p>
					We highly value any questions or comments. To reach us, send us a message <a href="mailto:dukehalapps@gmail.com?subject=SHOW:">here</a>!
				</p>
				<p>
					If you're experiencing any issues, we recommend using the latest version of Chrome.
				</p>
				<!-- <div id="contactForm">
					<form id="contactFormInner" action="mailto:dukehalapps@gmail.com" method="post" enctype="multipart/form-data">
						<strong>Subject:</strong> <br><input type="text" name="subject"><br><br>
						<strong>Message:</strong> <br><textarea rows="4" cols="50" name="body"></textarea><br><br>
						<input class="button" type="submit" value="Compose Message" style="color: black;">
					</form>
				</div> -->
			</div>
<?php require_once('includes/page_parts/footer.php');?>

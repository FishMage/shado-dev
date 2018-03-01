<?php
/****************************************************************************
*																			*
*	File:		init.php  													*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This file initializes php.									*
*																			*
****************************************************************************/

//	Start session

	session_start();

	if (empty($_SESSION['session_started'])) {
		require_once('includes/session_management/set_session_vars.php');
	}
$dir = getcwd();
$_SESSION['session_dir'] = $dir.'/out/';
/****************************************************************************
*																			*
*	Function:	connect_database											*
*																			*
*	Purpose:	To create and return a connection to a mySQL database 		*
*																			*
****************************************************************************/

function connect_database() {

//	Store login credentials

	$servername = "localhost";
	$username = "show_usr";
	$password = "trainz";
	$dbname = "show_des";

//	Create and check connection

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
	    die("Database connection failed: " . $conn->connect_error);
	}

//	Return connection

	return $conn;
}

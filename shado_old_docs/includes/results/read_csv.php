<?php
/****************************************************************************
*																			*
*	File:		read_csv.php  												*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This file fetches the simulation results.					*
*																			*
****************************************************************************/

//	Initialize session

	require_once('includes/session_management/init.php');

//	This is for engineer

	$low_count = 0;
	$normal_count = 0;
	$high_count = 0;

    $rows = file($_SESSION['session_dir'] . 'engineer.csv');
    error_log("current_dir: ".getcwd(),0);
    error_log("session_dir: ".$_SESSION['session_dir'],0);
echo "<script>console.log( 'Debug Objects: " . $_SESSION['session_dir']. "' );</script>";
    $last_row = array_pop($rows);

    $line_of_text = str_getcsv($last_row, ',');
    $num = count($line_of_text);

    for($i=1; $i<$num; $i++){
        $var=(float)$line_of_text[$i];
        if($var<0.3) {
            $low_count++;
        } else {
            if($var<0.7) {
                $normal_count++;
            } else {
                $high_count++;
            }
        }
    }

    $_SESSION['low_count_0']=$low_count;
	$_SESSION['normal_count_0']=$normal_count;
	$_SESSION['high_count_0']=$high_count;

	// This is for conductor

	if (in_array('conductor', $_SESSION['parameters']['assistants'])) {

        $low_count = 0;
        $normal_count = 0;
        $high_count = 0;

        $rows = file($_SESSION['session_dir'] . 'conductor.csv');
        $last_row = array_pop($rows);

        $line_of_text = str_getcsv($last_row, ',');
        $num = count($line_of_text);

        for($i=1; $i<$num; $i++){
            $var=(float)$line_of_text[$i];
            if($var<0.3) {
                $low_count++;
            } else {
                if($var<0.7) {
                    $normal_count++;
                } else {
                    $high_count++;
                }
            }
        }

		$_SESSION['low_count_1']=$low_count;
		$_SESSION['normal_count_1']=$normal_count;
		$_SESSION['high_count_1']=$high_count;
	}

	// This is for dispatcher

    $low_count = 0;
    $normal_count = 0;
    $high_count = 0;

    $rows = file($_SESSION['session_dir'] . 'dispatcher.csv');
    $last_row = array_pop($rows);

    $line_of_text = str_getcsv($last_row, ',');
    $num = count($line_of_text);

    for($i=1; $i<$num; $i++){
        $var=(float)$line_of_text[$i];
        if($var<0.3) {
            $low_count++;
        } else {
            if($var<0.7) {
                $normal_count++;
            } else {
                $high_count++;
            }
        }
    }

    $_SESSION['low_count_2']=$low_count;
    $_SESSION['normal_count_2']=$normal_count;
    $_SESSION['high_count_2']=$high_count;

?>

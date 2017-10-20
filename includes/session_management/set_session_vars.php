<?php
    session_start();

/****************************************************************************
*
*	File:		set_session_vars.php
*
*	Author:		Branch Vincent
*
*	Date:		Sep 9, 2016
*
* 	Editor:     Rocky Li
*
*   Date:       Sep 21, 2017
*
*	Purpose:	This sets default session variables, which is defined by
*               the default_params.txt file
*
****************************************************************************/

//  Set session id and directory

    $_SESSION['session_id'] = uniqid();
//    $dir = sys_get_temp_dir() . '/' . $_SESSION['session_id'];
//    mkdir($dir);
    $dir = getcwd();
    $_SESSION['session_dir'] = $dir.'/out/';
    error_log("current_dir: ".getcwd(),0);
    error_log("session_dir: ".$_SESSION['session_dir'],0);
    echo $dir;
    $_SESSION['des_version'] = '1.0.0';

//  Create session variables

    $_SESSION['default_tasks'] = array();

    $_SESSION['parameters'] = array();
    $_SESSION['tasks'] = array();
    $_SESSION['assistants'] = array();
    // $_SESSION['taskNames'] = array();
    // $_SESSION['taskPrty'] = array();
    // $_SESSION['taskArrDist'] = array();
    // $_SESSION['taskArrPms'] = array();
    // $_SESSION['taskSerDist'] = array();
    // $_SESSION['taskSerPms'] = array();
    // $_SESSION['taskExpDist'] = array();
    // $_SESSION['taskExpPmsLo'] = array();
    // $_SESSION['taskExpPmsHi'] = array();
    // $_SESSION['taskAffByTraff'] = array();
    // $_SESSION['taskAssocOps'] = array();
    // $_SESSION['taskDescription'] = array();

//  Set basic settings

    $_SESSION['parameters']['hours'] = 8;
    $_SESSION['parameters']['begin'] = '09:00 AM';
    $_SESSION['parameters']['end'] = '05:00 PM';

    $_SESSION['parameters']['traffic_chars'] = array();
    for ($i = 0; $i < 8; $i++) {
        $_SESSION['parameters']['traffic_chars'][] = 'm';
        $_SESSION['parameters']['traffic_nums'][] = 1;
    }

    $_SESSION['parameters']['assistants'] = array();
    $_SESSION['parameters']['assistants'][] = 'engineer';

    $_SESSION['parameters']['sector_num']  = 2;

//  Read in default values

    $file = fopen('static_data/params.txt', 'r') or die('Unable to open default parameter file!
     Please return to check and update your settings.');

//  Set default number of replications

    $line = fscanf($file, "%s %d");
    $_SESSION['parameters']['reps'] = $line[1];

//  Set default number of trains

    $line = fscanf($file, "%s %d");
    $_SESSION['parameters']['trains'] = $line[1];

//  Set default number of operators

    $line = fscanf($file, "%s %d");
    $num_ops = $line[1];

//  Set default number of dispatchers and their tasks

    $line = fscanf($file, "%s %d");
    $_SESSION['parameters']['dispatchnum'] = $line[1];

    $line = strstr(fgets($file),"\t");
    $dat = array_map('intval', explode(" ", $line));
    $_SESSION['parameters']['dispatchtasks'] = $dat;

//  Set default number of task types

    $line = fscanf($file, "%s %d");
    $num_tasks = $line[1];

//  Read in assistants

    for ($i = 0; $i < $num_ops; $i++) {

    //  Set name

        $line = strstr(fgets($file), "\t");
        $line = strtolower(trim($line));
        $_SESSION['assistants'][$line] = array();
        $curr_op = $line;

    //  Set tasks to handle

        $line = strstr(fgets($file), "\t");
//        echo $line;
        $data = array_map('intval', explode(" ", $line));
        $_SESSION['assistants'][$curr_op]['tasks'] = $data;
    }

    $_SESSION['assistants']['custom'] = array();
    $_SESSION['assistants']['custom']['name'] = 'custom';
    $_SESSION['assistants']['custom']['tasks'] = array();

//  Read in tasks

    for ($i = 0; $i < $num_tasks; $i++) {

    //  Set task name
        $line = strstr(fgets($file), "\t");
        $line = strtolower(trim($line));
        $_SESSION['tasks'][$line] = array();
        $curr_task = $line;

    //  Set priority
        list($name, $data[0], $data[1], $data[2]) = fscanf($file, "%s %d %d %d");
        // $_SESSION['taskPrty'][$i] = $data;
        $_SESSION['tasks'][$curr_task]['priority'] = $data;
//        echo "\nThis is original data: ";
//        foreach($data as $da){
//            echo $da . " ";
//        }
//        echo "\n";
//        foreach($_SESSION['tasks'][$curr_task]['priority'] as $ea){
//            echo $ea . " ";
//        }

    //  Set arrival distribution type
        $line = fscanf($file, "%s %s");
        // $_SESSION['taskArrDist'][$i] = $line[1];
        $_SESSION['tasks'][$curr_task]['arrDist'] = $line[1];

    //  Set arrival distribution parameters
        list($name, $data[0], $data[1], $data[2]) = fscanf($file, "%s %f %f %f");
        // $_SESSION['taskArrPms'][$i] = $data;
        $_SESSION['tasks'][$curr_task]['arrPms'] = $data;


    //  Set service distribution type
        $line = fscanf($file, "%s %s");
        // $_SESSION['taskSerDist'][$i] = $line[1];
        $_SESSION['tasks'][$curr_task]['serDist'] = $line[1];

    //  Set service distribution parameters
        list($name, $data2[0], $data2[1]) = fscanf($file, "%s %f %f");
        // $_SESSION['taskSerPms'][$i] = $data2;
        $_SESSION['tasks'][$curr_task]['serPms'] = $data2;

    //  Set expiration distribution type
        $line = fscanf($file, "%s %s");
        // $_SESSION['taskExpDist'][$i] = $line[1];
        $_SESSION['tasks'][$curr_task]['expDist'] = $line[1];

    //  Set expiration distribution parameters (lo + hi)
        list($name, $data[0], $data[1], $data[2]) = fscanf($file, "%s %f %f %f");
        // $_SESSION['taskExpPmsLo'][$i] = $data;
        $_SESSION['tasks'][$curr_task]['expPmsLo'] = $data;

        list($name, $data[0], $data[1], $data[2]) = fscanf($file, "%s %f %f %f");
        // $_SESSION['taskExpPmsHi'][$i] = $data;
        $_SESSION['tasks'][$curr_task]['expPmsHi'] = $data;

    //  Set affected by traffic
        list($name, $data[0], $data[1], $data[2]) = fscanf($file, "%s %d %d %d");
        // $_SESSION['taskAffByTraff'][$i] = $data;
        $_SESSION['tasks'][$curr_task]['affByTraff'] = $data;

    //  Set islinked property and triggered property

        $line = fscanf($file, "%s %d");
        $_SESSION['tasks'][$curr_task]['isLinked'] = $line[1];

        $line = fscanf($file, "%s %d");
        $_SESSION['tasks'][$curr_task]['triggered'] = $line[1];

    //  Set associated operators
        // $line = strstr(fgets($file), "\t");
        // $data = array_map('intval', explode(" ", $line));
        // // $_SESSION['taskAssocOps'][$i] = $data;
        // $_SESSION['tasks'][$curr_task]['assocOps'] = $data;
    }
    fclose($file);

//  Set assistant descriptions


    $_SESSION['assistants']['engineer']['description'] = 'The engineer is responsible for operating the train';
    $_SESSION['assistants']['conductor']['description'] = 'The freight conductor supervises train conditions on the ground at terminal points and remains attentive to the engineer while the train is in motion in the case of emergency, when action could be needed';
    $_SESSION['assistants']['positive train control']['description'] = 'Positive Train Control (PTC), set to be fully implemented by 2018, is an embedded feature of railroads that automatically manages speed restrictions and emergency braking without human input';
    $_SESSION['assistants']['cruise control']['description'] = 'Cruise control can offload motion planning tasks that involve the locomotive control system of throttle and dynamic braking';
    $_SESSION['assistants']['custom']['description'] = 'You can define this assistant';


//  Set task descriptions

    $_SESSION['tasks']['communicating']['description'] = 'Filtering through relevant information for the operation and communicating information that may impact the macro-level network of operations';
    $_SESSION['tasks']['exception handling']['description'] = 'Attending to unexpected or unusual situations that must be handled in order to continue with the trip';
    $_SESSION['tasks']['paperwork']['description'] = 'Reviewing and recording operating conditions';
    $_SESSION['tasks']['maintenance of way interactions']['description'] = 'Maintaining situational awareness of other crews along the track';
    $_SESSION['tasks']['temporary speed restrictions']['description'] = 'Recalling information issued on track bulletins and adapting to updates while train is in motion';
    $_SESSION['tasks']['signal response management']['description'] = 'Maintaining attentiveness to direction from track signaling system and responsive to proper control system within a safely allotted time';
    $_SESSION['tasks']['monitoring inside']['description'] = 'Maintaining attentiveness to informational displays and to engineer\'s performance to maintain a safe operation';
    $_SESSION['tasks']['monitoring outside']['description'] = 'Maintaining attentiveness to warnings and environmental conditions that may affect operations';
    $_SESSION['tasks']['planning ahead']['description'] = 'Maneuvering locomotive control system for throttle, braking and other subtasks like horn-blowing before railroad crossing';

    $_SESSION['default_tasks'] = $_SESSION['tasks'];


// Task description for conductor

    $_SESSION['communicating']['description'] = 'Filtering through relevant information for the operation and communicating information that may impact the macro-level network of operations';
    $_SESSION['exception handling']['description'] = "Manual tasks outside of the locomotive cab that may be passed on to the conductor";
    $_SESSION['paperwork']['description'] = 'Recording information about the train (apart from the locomotive) that is not of concern to the engineer but essential for the business of freight';
    $_SESSION['maintenance of way interactions']['description'] = 'Supporting the engineer in meeting required speed limits throughout the trip';
    $_SESSION['temporary speed restrictions']['description'] = 'Supporting the engineer in meeting required speed limits throughout the trip';
    $_SESSION['signal response management']['description'] = 'Supporting the engineer in meeting required speed limits throughout the trip';
    $_SESSION['monitoring inside']['description'] = 'Paying attention to the engineer’s task performance';
    $_SESSION['monitoring outside']['description'] = 'Maintaining attentiveness to warnings and environmental conditions that may affect operations';
    $_SESSION['planning ahead']['description'] = 'Supporting the engineer in meeting required speed limits throughout the trip';

// Run Simulation Button Description
    $_SESSION['run simulation']['description'] = 'the number of replications, or the number of simulated trips. Note that more trips provide more precise results, but it may also increase the processing time';

// Number of Batches
    $_SESSION['parameters']['numBatch'] = 1;
//  Set empty task

    $_SESSION['empty_task'] = array();
    // $_SESSION['empty_task']['tasks'] = array(0);
    $_SESSION['empty_task']['priority'] = array(3, 3, 3);
    $_SESSION['empty_task']['arrDist'] = 'E';
    $_SESSION['empty_task']['arrPms'] = array(1/30, 1/30, 1/30);
    $_SESSION['empty_task']['serDist'] = 'E';
    $_SESSION['empty_task']['serPms'] = array(5, 5);
    $_SESSION['empty_task']['expDist'] = 'E';
    $_SESSION['empty_task']['expPmsLo'] = array(0, 0, 0);
    $_SESSION['empty_task']['expPmsHi'] = array(0, 0, 0);
    $_SESSION['empty_task']['affByTraff'] = array(0, 0, 0);
    $_SESSION['empty_task']['isLinked'] = 0;
    $_SESSION['empty_task']['triggered'] = -1;
    $_SESSION['empty_task']['description'] = "You have defined this task";

//  Set session

    $_SESSION['session_started'] = true;
    $_SESSION['session_results'] = false;

    // function read_param($file, $session_prefix) {
    //     $line = fscanf($file, "%s %s");
    //     echo "line = $line \n";
    //     $_SESSION["$session_prefix"]["$line[0]"] = $line[1];
    //     $line = strtolower(trim($line));
    //     if (is_numeric($line[1])) echo "$line[1] is numeric! \n";
    // }

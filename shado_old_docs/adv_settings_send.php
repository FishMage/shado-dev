<?php
//	Initialize session

	require_once('includes/session_management/init.php');

//	Get selected tasks

	$curr_tasks = explode(',', $_POST['current_tasks']);

//	Remove old parameters

	$_SESSION['tasks'] = array();
	foreach (array_keys($_SESSION['assistants']) as $assistant)
		$_SESSION['assistants'][$assistant]['tasks'] = array();

//	Save replications

//	$_SESSION['parameters']['reps'] = (int)$_POST["num_reps"];

//	Loop through each task type

	foreach ($curr_tasks as $task_num) {

	// 	Store task names and descriptions

		$curr_task = strtolower($_POST["t".$task_num."_name"]);
		if (in_array($curr_task, array_keys($_SESSION['default_tasks'])))
			$_SESSION['tasks'][$curr_task]['description'] = $_SESSION['default_tasks'][$curr_task]['description'];
		else
			$_SESSION['tasks'][$curr_task]['description'] = $_SESSION['empty_task']['description'];

	// 	Store priorities

		$_SESSION['tasks'][$curr_task]['priority'] = array(
			(int)$_POST["t".$task_num."_priority_p0"],
			(int)$_POST["t".$task_num."_priority_p1"],
			(int)$_POST["t".$task_num."_priority_p2"]);

	// 	Store arrival distribution type

		$_SESSION['tasks'][$curr_task]['arrDist'] = "E";

	// 	Store arrival distribution parameters

		$_SESSION['tasks'][$curr_task]['arrPms'] = array(
			(float)$_POST["t".$task_num."_arrTime_p0"],
			(float)$_POST["t".$task_num."_arrTime_p1"],
			(float)$_POST["t".$task_num."_arrTime_p2"]);

		for ($k = 0; $k < sizeof($_SESSION['tasks'][$curr_task]['arrPms']); $k++) {
			if ($_SESSION['tasks'][$curr_task]['arrPms'][$k] != 0) {
				$_SESSION['tasks'][$curr_task]['arrPms'][$k] = 1/$_SESSION['tasks'][$curr_task]['arrPms'][$k];
			}
		}

	// 	Store service distribution type

		$_SESSION['tasks'][$curr_task]['serDist'] = $_POST["t".$task_num."_serTimeDist"];

	// 	Store service distribution parameters

		if ($_SESSION['tasks'][$curr_task]['serDist'] == "E") {
			$val = (float)$_POST["t".$task_num."_exp_serTime_0"];
			if ($val != 0) $val = 1/$val;
			$_SESSION['tasks'][$curr_task]['serPms'] = array($val, 0);
			// print_r($_SESSION['tasks'][$curr_task]['serPms']);
		} else if ($_SESSION['tasks'][$curr_task]['serDist'] == "L") {
			$_SESSION['tasks'][$curr_task]['serPms'] = array(
				(float)$_POST["t".$task_num."_log_serTime_0"],
				(float)$_POST["t".$task_num."_log_serTime_1"]);
		} else {
			$_SESSION['tasks'][$curr_task]['serPms'] = array(
				(float)$_POST["t".$task_num."_uni_serTime_0"],
				(float)$_POST["t".$task_num."_uni_serTime_1"]);
		}

	// 	Store expiration distribution type

		$_SESSION['tasks'][$curr_task]['expDist'] = "E";

	//	Store expiration distribution parameters (lo + hi)

		$_SESSION['tasks'][$curr_task]['expPmsLo'] = array(0, 0, 0);
		$_SESSION['tasks'][$curr_task]['expPmsHi'] = array(0, 0, 0);

	// 	Store affected by traffic

		$_SESSION['tasks'][$curr_task]['affByTraff'] = array(
			(int)$_POST["t".$task_num."_affByTraff_p0"],
			(int)$_POST["t".$task_num."_affByTraff_p1"],
			(int)$_POST["t".$task_num."_affByTraff_p2"]);

	// 	Store associated operators

		$op_num = 0;
		foreach (array_keys($_SESSION['assistants']) as $assistant) {
			if (isset($_POST["t$task_num" . "_op$op_num"]) && $_POST["t$task_num" . "_op$op_num"] == 'on') {
				$_SESSION['assistants'][$assistant]['tasks'][] = (int)array_search($task_num, $curr_tasks);
			}
			$op_num++;
		}
	}
	// print_r($_SESSION['assistants']);


//	Continue to next page

    if (isset($_POST['run_sim'])) {
        header('Location: run_sim.php');
    } else if (isset($_POST['basic_settings'])) {
        header('Location: basic_settings.php');
    } else {
        die("Could not determine action. Please return to check and update your settings.");
    }

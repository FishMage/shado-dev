<?php
/****************************************************************************
*																			*
*	File:		adv_settings.php  											*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This page allows the user to change advanced settings for  	*
*				the simulation. 											*
*																			*
****************************************************************************/

//	Start session

	require_once('includes/session_management/init.php');

//	Set header info

	$page_title = 'Advanced Settings';
	$html_head_insertions = '<script type="text/javascript" src="scripts/adv_settings.js"></script>';

	require_once('includes/page_parts/header.php');
	require_once('includes/page_parts/side_navigation.php');

/****************************************************************************
*																			*
*	Function:	print_task_ids												*
*																			*
*	Purpose:	To print the current active tasks						 	*
*																			*
****************************************************************************/

	function print_task_ids() {
		for ($i = 0; $i < sizeof($_SESSION['tasks']); $i++) {
			if ($i == 0) echo $i;
			else echo "," . $i;
		}
	}
?>

			<div id="settingsPage" class="page">
                <h1 class="pageTitle" style="font-family: 'Lucida Grande'">Input Advanced Operater Conditions for Batch</h1>
<!--                --><?php //echo $_SESSION['parameters']['numBatch'];?>

                <div class="tab" style=" font-family: 'Lucida Grande'; box-shadow: 0px 8px 8px 0px rgba(0,0,0,0.2);">
                    <button id="btn_dispatcher" class="tablinks" onclick="switchBatch(event, 'dispatcher')">Dispatcher</button>
                    <button id="defaultOpen" class="tablinks" onclick="switchBatch(event, 'batch_1')" >Sector 1</button>
                    <button id="btn_batch_2"class="tablinks" onclick="switchBatch(event, 'batch_2')">Sector 2</button>
                    <button id="btn_batch_3"class="tablinks" onclick="switchBatch(event, 'batch_3')">Sector 3</button>
                </div>
                <br>
<!--Dispatcher-->
                <div id="dispatcher" class="tabcontent" >

                        <form class="pure-form " id="taskParameters" action="adv_settings_send.php" method="post" style=" margin-bottom: 200px">
                            <input id="current_tasks" name="current_tasks" type="hidden" value=<?php print_task_ids();?>>
                            <script>displayDefault()</script>

                        <div class="stepBox">
                            <h2 style="font-family: 'Lucida Grande'">Task Details</h2>
                            Below, you can view and change the underlying assumptions for each task.

                        </div>
                            <br>
                            <h1  style="text-align: center;padding:5px; margin: auto; font-family: 'Lucida Grande'; background-color: #3e67ad; color: white; border-radius: 5px">Dispatcher</h1>
                        <div class = "pure-table pure-table-bordered"id='taskParameterTable' style="font-family: 'Lucida Grande'">
                            <?php
                            $index = 0;
                            foreach (array_keys($_SESSION['tasks']) as $task) {
                                $taskNum = $index++;
                                echo "<div id=task_$taskNum>";
                                include('includes/adv_settings/task_settings_table.php');
                                echo "<br> </div>";
                            }
                            while ($index < 15) {
                                $task = "default";
                                $taskNum = $index++;
                                echo "<div id=task_$taskNum class='remove'>";
                                include('includes/adv_settings/task_settings_table.php');
                                echo "<br> </div>";
                            }
                            ?>
                        </div>
                        <div id="taskAdder" style="text-align: center; padding-bottom: 20px;" >
                            <h3 style="color: #4CAF50; font-family: 'Lucida Grande'"><button type="button" class="roundButton" onclick=<?php echo "addTask(0," . sizeof($_SESSION['tasks']) . ")"; ?> style="background-color: #4CAF50;"><strong>+</strong></button> Add Task</h3>
                        </div>
                            <div id="bottomNav" action="adv_settings_send.php" method="post" style="margin-top: 30px; margin-left: 60px">
                                <ul>
                                    <li>
                                        <input type="submit" class=" pure-button" name="basic_settings" value="&#8678 Basic Conditions" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">
                                    </li>
                                    <li>
                                        <button type="button" class=" pure-button" onclick="location.href='reset_session_vars.php';" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); background-color: darkgray">Restore Defaults</button>
                                    </li>
                                    <li>

                                        <button type="button" class=" pure-button" onclick="location.href='sys_settings.php';" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">System Settings</button>
                                    </li>
                                    <!--							<li>-->
                                    <!--								<input type="submit" class="button" name="run_sim" value="Run Simulation &#8680" style="background-color: #4CAF50;">-->
                                    <!--							</li>-->
                                    <li>
                                        <div class="dropdown" style="margin-top: -5px">
                                            <button  class="pure-button" name="run_sim" style="background-color: #4CAF50; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">Run Simulation &#8680<span class="hint--right hint--rounded hint--large" aria-label= "the number of replications, or the number of simulated trips. Note that more trips provide more precise results, but it may also increase the processing time"><sup>(&#x003F;)</sup></span> </button>
                                            <div class="dropdown-content">
                                                <button type="submit" name="run_sim" ><span>For 100 shifts</span></button>
                                                <button onclick="location.href='adv_settings.php';"><span>For 1000 shifts</span></button>
                                                <button onclick="location.href='adv_settings.php';" ><span>For 10000 shifts</span></button>

                                            </div>
                                        </div>
                                    <li>
                                </ul>


                            </div>
                    </form>
                </div>
<!--Batch 1-->
             <div id="batch_1" class="tabcontent" >

				<form class="pure-form " id="taskParameters" action="adv_settings_send.php" method="post">
					<input id="current_tasks" name="current_tasks" type="hidden" value=<?php print_task_ids();?>>
                    <script>displayDefault()</script>

                    <div class="stepBox">
                        <h2 style="font-family: 'Lucida Grande'">Task Details</h2>
                            Below, you can view and change the underlying assumptions for each task.
                    </div>
                    <br>
                    <h1 style="text-align: center;padding:5px; margin: auto; font-family: 'Lucida Grande'; background-color: #7cd0ff;border-radius: 5px; color: white">Sector 1</h1>
					<div class = "pure-table pure-table-bordered"id='taskParameterTable' style="font-family: 'Lucida Grande'">
						<?php
							$index = 0;
							foreach (array_keys($_SESSION['tasks']) as $task) {
								$taskNum = $index++;
								echo "<div id=b1_task_$taskNum>";
						        include('includes/adv_settings/task_settings_table.php');
								echo "<br> </div>";
						    }
							while ($index < 15) {
								$task = "default";
								$taskNum = $index++;
								echo "<div id=b1_task_$taskNum class='remove'>";
						        include('includes/adv_settings/task_settings_table.php');
								echo "<br> </div>";
							}
						?>
					</div>
					<div id="taskAdder_b1" style="text-align: center; padding-bottom: 20px;" >
						<h3 style="color: #4CAF50; font-family: 'Lucida Grande'"><button type="button" class="roundButton" onclick=<?php echo "addTask(1," . sizeof($_SESSION['tasks']) . ")"; ?> style="background-color: #4CAF50;"><strong>+</strong></button> Add Task</h3>
					</div>
                    <div id="bottomNav" action="adv_settings_send.php" method="post" style="margin-top: 30px; margin-left: 60px">
                        <ul>
                            <li>
                                <input type="submit" class=" pure-button" name="basic_settings" value="&#8678 Basic Conditions" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">
                            </li>
                            <li>
                                <button type="button" class=" pure-button" onclick="location.href='reset_session_vars.php';" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); background-color: darkgray">Restore Defaults</button>
                            </li>
                            <li>

                                <button type="button" class=" pure-button" onclick="location.href='sys_settings.php';" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">System Settings</button>
                            </li>
                            <!--							<li>-->
                            <!--								<input type="submit" class="button" name="run_sim" value="Run Simulation &#8680" style="background-color: #4CAF50;">-->
                            <!--							</li>-->
                            <li>
                                <div class="dropdown" style="margin-top: -5px">
                                    <button  class="pure-button" name="run_sim" style="background-color: #4CAF50; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">Run Simulation &#8680<span class="hint--right hint--rounded hint--large" aria-label= "the number of replications, or the number of simulated trips. Note that more trips provide more precise results, but it may also increase the processing time"><sup>(&#x003F;)</sup></span> </button>
                                    <div class="dropdown-content">
                                        <button type="submit" name="run_sim" ><span>For 100 shifts</span></button>
                                        <button onclick="location.href='adv_settings.php';"><span>For 1000 shifts</span></button>
                                        <button onclick="location.href='adv_settings.php';" ><span>For 10000 shifts</span></button>

                                    </div>
                                </div>
                            <li>
                        </ul>


                    </div>
				</form>
             </div>


<!--Batch 2 -->
                <div id="batch_2" class="tabcontent" >

                    <form class="pure-form " id="taskParameters" action="adv_settings_send.php" method="post">
                        <input id="current_tasks" name="current_tasks" type="hidden" value=<?php print_task_ids();?>>



                        <div class="stepBox">
                            <h2 style="font-family: 'Lucida Grande'">Task Details</h2>
                            Below, you can view and change the underlying assumptions for each task.
                        </div>
                        <br>
                        <h1 style="text-align: center;padding:5px; margin: auto; font-family: 'Lucida Grande'; background-color: #639752; color: white;border-radius: 5px">Sector 2</h1>
                        <div class = "pure-table pure-table-bordered"id='taskParameterTable' style="font-family: 'Lucida Grande'">
                            <?php
                            $index = 0;
                            foreach (array_keys($_SESSION['tasks']) as $task) {
                                $taskNum = $index++;
                                echo "<div id=b2_task_$taskNum>";
                                include('includes/adv_settings/task_settings_table.php');
                                echo "<br> </div>";
                            }
                            while ($index < 15) {
                                $task = "default";
                                $taskNum = $index++;
                                echo "<div id=b2_task_$taskNum class='remove'>";
                                include('includes/adv_settings/task_settings_table.php');
                                echo "<br> </div>";
                            }
                            ?>
                        </div>
                        <div id="taskAdder_b2" style="text-align: center; padding-bottom: 20px;" >
                            <h3 style="color: #4CAF50; font-family: 'Lucida Grande'"><button type="button" class="roundButton" onclick=<?php echo "addTask(2," . sizeof($_SESSION['tasks']) . ")"; ?> style="background-color: #4CAF50;"><strong>+</strong></button> Add Task</h3>
                        </div>
                        <div id="bottomNav" action="adv_settings_send.php" method="post" style="margin-top: 30px; margin-left: 60px">
                            <ul>
                                <li>
                                    <input type="submit" class=" pure-button" name="basic_settings" value="&#8678 Basic Conditions" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">
                                </li>
                                <li>
                                    <button type="button" class=" pure-button" onclick="location.href='reset_session_vars.php';" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); background-color: darkgray">Restore Defaults</button>
                                </li>
                                <li>

                                    <button type="button" class=" pure-button" onclick="location.href='sys_settings.php';" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">System Settings</button>
                                </li>
                                <!--							<li>-->
                                <!--								<input type="submit" class="button" name="run_sim" value="Run Simulation &#8680" style="background-color: #4CAF50;">-->
                                <!--							</li>-->
                                <li>
                                    <div class="dropdown" style="margin-top: -5px">
                                        <button  class="pure-button" name="run_sim" style="background-color: #4CAF50; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">Run Simulation &#8680<span class="hint--right hint--rounded hint--large" aria-label= "the number of replications, or the number of simulated trips. Note that more trips provide more precise results, but it may also increase the processing time"><sup>(&#x003F;)</sup></span> </button>
                                        <div class="dropdown-content">
                                            <button type="submit" name="run_sim" ><span>For 100 shifts</span></button>
                                            <button onclick="location.href='adv_settings.php';"><span>For 1000 shifts</span></button>
                                            <button onclick="location.href='adv_settings.php';" ><span>For 10000 shifts</span></button>

                                        </div>
                                    </div>
                                <li>
                            </ul>


                        </div>
                    </form>
                </div>
<!-- Batch 3-->
                <div id="batch_3" class="tabcontent" >

                    <form class="pure-form " id="taskParameters" action="adv_settings_send.php" method="post">
                        <input id="current_tasks" name="current_tasks" type="hidden" value=<?php print_task_ids();?>>



                        <div class="stepBox">
                            <h2 style="font-family: 'Lucida Grande'">Task Details</h2>
                            Below, you can view and change the underlying assumptions for each task.
                        </div>
                        <br>
                        <h1 style="text-align: center; padding:5px; margin: auto; font-family: 'Lucida Grande'; background-color: #b9594b;border-radius: 5px; color: white">Sector 3</h1>
                        <div class = "pure-table pure-table-bordered"id='taskParameterTable' style="font-family: 'Lucida Grande'">
                            <?php
                            $index = 0;
                            foreach (array_keys($_SESSION['tasks']) as $task) {
                                $taskNum = $index++;
                                echo "<div id=b3_task_$taskNum>";
                                include('includes/adv_settings/task_settings_table.php');
                                echo "<br> </div>";
                            }
                            while ($index < 15) {
                                $task = "default";
                                $taskNum = $index++;
                                echo "<div id=b3_task_$taskNum class='remove'>";
                                include('includes/adv_settings/task_settings_table.php');
                                echo "<br> </div>";
                            }
                            ?>
                        </div>
                        <div id="taskAdder_b3" style="text-align: center; padding-bottom: 20px;" >
                            <h3 style="font-family: 'Lucida Grande';color: #4CAF50"><button type="button" class="roundButton" onclick=<?php echo "addTask(3," . sizeof($_SESSION['tasks']) . ")"; ?> style="background-color: #4CAF50;"><strong>+</strong></button> Add Task</h3>
                        </div>
                        <div id="bottomNav" action="adv_settings_send.php" method="post" style="margin-top: 30px; margin-left: 60px">
                            <ul>
                                <li>
                                    <input type="submit" class=" pure-button" name="basic_settings" value="&#8678 Basic Conditions" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">
                                </li>
                                <li>
                                    <button type="button" class=" pure-button" onclick="location.href='reset_session_vars.php';" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); background-color: darkgray">Restore Defaults</button>
                                </li>
                                <li>

                                    <button type="button" class=" pure-button" onclick="location.href='sys_settings.php';" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">System Settings</button>
                                </li>
                                <!--							<li>-->
                                <!--								<input type="submit" class="button" name="run_sim" value="Run Simulation &#8680" style="background-color: #4CAF50;">-->
                                <!--							</li>-->
                                <li>
                                    <div class="dropdown" style="margin-top: -5px">
                                        <button  class="pure-button" name="run_sim" style="background-color: #4CAF50; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">Run Simulation &#8680<span class="hint--right hint--rounded hint--large" aria-label= "the number of replications, or the number of simulated trips. Note that more trips provide more precise results, but it may also increase the processing time"><sup>(&#x003F;)</sup></span> </button>
                                        <div class="dropdown-content">
                                            <button type="submit" name="run_sim" ><span>For 100 shifts</span></button>
                                            <button type="submit" name="run_sim"><span>For 1000 shifts</span></button>
                                            <button type="submit" name="run_sim" ><span>For 10000 shifts</span></button>

                                        </div>
                                    </div>
                                <li>
                            </ul>


                        </div>
                    </form>
                </div>


            </div>
<?php require_once("includes/page_parts/footer.php");?>

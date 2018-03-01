<?php
/****************************************************************************
*																			*
*	File:		basic_settings.php  										*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This page allows the user to change basic settings for the 	*
*				simulation. 												*
*																			*
****************************************************************************/

//	Initialize session

	require_once('includes/session_management/init.php');

//	Set header information

	$page_title = 'Run Simulation';
	$html_head_insertions = '<script type="text/javascript" src="scripts/basic_settings.js"></script>';
	$html_head_insertions .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>';
	require_once('includes/page_parts/header.php');
	require_once('includes/page_parts/side_navigation.php');



//$_SESSION['parameters']['numBatch'] = 1;
?>

	<div id="runSimulationPage" class="page" action="basic_settings_send.php" method="post" style="font-family: 'Lucida Grande';margin-bottom: 200px">

        <div class="stepBox" style="">
            <h1 class="pageTitle"style=" font-family: 'Lucida Grande'">Input Basic Dispatch Conditions</h1>
            <p>
                To get started, provide the following information. Then, you can either run the simulation or change more assumptions
                <!-- What time of day does your operator begin <strong>(1)</strong> and end <strong>(2)</strong> his/her shift? And what’s the level of traffic <strong>(3)</strong> in the region during this shift? Lastly, specify any additional operators or technologies <strong>(4)</strong> that will assist the engineer during the trip.
                And if you're a more advanced user, look at the advanced settings. -->
            </p>
        </div>
        <br>
        <div class="tab remove" style=" font-family: 'Lucida Grande'; width: auto; box-shadow: 0px 8px 8px 0px rgba(0,0,0,0.2)">
<!--                <button id="btn_dispatcher" class="tablinks" onclick="switchBatch(event, 'dispatcher')">Dispatcher</button>-->
                <button id="btn_batch_1"class="tablinks" onclick="switchBatch(event, 'batch_1')">Sector 1</button>
                <button id="btn_batch_2"class="tablinks" onclick="switchBatch(event, 'batch_2')">Sector 2</button>
                <button id="btn_batch_3"class="tablinks" onclick="switchBatch(event, 'batch_3')">Sector 3</button>
        </div>


        <form class="pure-form " action="basic_settings_send.php" method="post" style="text-align:center">
        <div class="startEndTime stepBox" style="">
<!--            <div class='stepCircle'>1</div>-->
            <h3 >Enter number of Dispatchers <span class="hint--bottom-right hint--rounded hint--large" aria-label=
                "Enter the number of dispatcher that should be at work."><sup>(?)</sup></span></h3>

            <select id='DispatchNum' onchange="calculate_dispatch();">
                <?php
                $tr = $_SESSION['parameters']['dispatchnum'];
                for ($i = 1; $i <= 4; $i++) {
                    $selected = '';
                    if ($i == $tr) $selected = ' selected="selected"';
                    $val = sprintf('%2d', $i);
                    echo "<option$selected>$val</option>";
                }
                ?>
            </select>

            <input id="dispatch_num" name="dispatch_num" type="hidden" value="<?php echo $_SESSION['parameters']['dispatchnum'];?>">
        </div>

            <div id=" numSector" class="StartEndTime stepBox" >
                <h3> Enter number of Sectors <span class="hint--bottom-right hint--rounded hint--large" aria-label=
                    "The number of sectors managed by selected dispatchers"><sup>(?)</sup></span></h3>
                <select  id= 'SecNum' onchange="changeNumSec();">
                    <option value="" disabled selected>Select</option>
                    <?php
                    $tr = $_SESSION['parameters']['sector_num'];
                    for ($i = 1; $i <= 3; $i++) {
//                        $selected = 'Select';
//                        if ($i == $tr) $selected = ' selected="selected"';
                        $val = sprintf('%2d', $i);
                        echo "<option >$val</option>";
                    }
                    ?>
                </select>
                <input id="sector_num" name="sector_num" type="hidden" value="<?php echo $_SESSION['parameters']['sector_num'];?>">
            </div>
            <script>displayDefault()</script>

<br>

 <!-- FORM 1-->
        <div id="batch_1" class="formBox tabcontent" style="font-family: 'Lucida Grande'">
            <h1 style=" border-radius: 5px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);padding:5px; margin: auto; font-family: 'Lucida Grande'; background-color: #7cd0ff; color: white">Sector 1</h1>
            <!--Section 1.1-->
            <div class="startEndTime stepBox " style="">
                <div class='stepCircle'>1</div>
                <h3 >How Many Trains in this Batch<span class="hint--bottom-right hint--rounded hint--large" aria-label= "Enter the time of day that your engineer begins his/her shift."><sup>(?)</sup></span></h3>
                <select id='TrainNum' onchange="calculate_train();">
                    <?php
                    $tr = $_SESSION['parameters']['trains'];
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = '';
                        if ($i == $tr) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option $selected>$val</option>";
                    }
                    ?>
                </select>

                <input id="train_num" name="train_num" type="hidden" value="<?php echo $_SESSION['parameters']['trains'];?>">
            </div>

<!-- Section 1.2-->
            <div class="startEndTime stepBox " style="margin-left: 0%" >
                <div class='stepCircle'>2</div>
                <h3 >When Does This Batch Trip Begin? <span class="hint--bottom-right hint--rounded hint--large" aria-label= "Enter the time of day that your engineer begins his/her shift."><sup>(?)</sup></span></h3>
                <select id='beginHour' onchange="calculate_time();">
                    <?php
                    $hr = (int)substr($_SESSION['parameters']['begin'], 0, 2);
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = '';
                        if ($i == $hr) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>:<select id='beginMin' onchange="calculate_time();">
                    <?php
                    $min = (int)substr($_SESSION['parameters']['begin'], 3, 5);
                    for ($i = 0; $i <= 50; $i+=10) {
                        $selected = '';
                        if ($i == $min) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>
                <select id='beginMd' onchange="calculate_time();">
                    <?php
                    $options = ['AM', 'PM'];
                    $md = substr($_SESSION['parameters']['begin'], 6);
                    for ($i = 0; $i < sizeof($options); $i++) {
                        $selected = '';
                        if ($options[$i] == $md) $selected = ' selected="selected"';
                        echo "<option$selected>$options[$i]</option>";
                    }
                    ?>
                </select>
                <input id="begin_time" name="begin_time" type="hidden" value="<?php echo $_SESSION['parameters']['begin'];?>">
            </div>
            <!-- Section 1.3-->
            <div class="startEndTime stepBox " style="margin-left: auto" >
                <div class='stepCircle'>3</div>
                <h3 >When Does This Batch Trip End? <span class="hint--bottom-left hint--rounded hint--large" aria-label= "Enter the time of day that your engineer is expected to end his/her shift."><sup>(?)</sup></span></h3>

                <select id='endHour' onchange="calculate_time();">
                    <?php
                    $hr = (int)substr($_SESSION['parameters']['end'], 0, 2);
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = '';
                        if ($i == $hr) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>:<select id='endMin' onchange="calculate_time();">
                    <?php
                    $min = (int)substr($_SESSION['parameters']['end'], 3, 5);
                    for ($i = 0; $i <= 50; $i+=10) {
                        $selected = '';
                        if ($i == $min) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>
                <select id='endMd' onchange="calculate_time();">
                    <?php
                    $options = ['AM', 'PM'];
                    $md = substr($_SESSION['parameters']['end'], 6);
                    for ($i = 0; $i < sizeof($options); $i++) {
                        $selected = '';
                        if ($options[$i] == $md) $selected = ' selected="selected"';
                        echo "<option$selected>$options[$i]</option>";
                    }
                    ?>
                </select>
                <input id="end_time" name="end_time" type="hidden" value="<?php echo $_SESSION['parameters']['end'];?>">
                <input id="num_hours" name="num_hours" type="hidden" value="<?php echo $_SESSION['parameters']['hours'];?>">
            </div>


<!--  Section 1.4-->
			<div class=" assistantsSelectStepOuter stepBox " >
				<div class='stepCircle'>4</div>
				<h3 id='assistants'>Who Will Assist the Engineer? <span class="hint--right hint--rounded hint--large" aria-label= "Identify any humans or technologies that will support the locomotive engineer. SHADO models their interaction by offloading certain tasks from the engineer."><sup>(?)</sup></span></h3>

				<div id="assist">
					<table class="pure-table" id="assistantsTable" style="font-family: 'Lucida Grande'" >
						<tr>
							<?php
								$assistant_names = array_keys($_SESSION['assistants']);
								for ($i = 1; $i < sizeof($assistant_names); $i++) {
									$assistant = $assistant_names[$i];
									$selected = '';
									if (in_array($assistant, $_SESSION['parameters']['assistants'])) {
										$selected = ' checked';
									}
									echo '<td><input ';
									if ($assistant == 'custom') echo 'id="custom_assistant" onchange="toggle_custom_settings();"';
									echo 'type="checkbox" name="assistant_' . $i  . '"'  . $selected . '>'  . ucwords($assistant) . ' ';
									echo "<span class='hint--right hint--rounded hint--large' aria-label= '". $_SESSION['assistants'][$assistant]['description'] . "'><sup> (&#x003F;) </sup></span>";
									echo '</td>';
								}
							?>
						</tr>
					</table>
				</div>
			</div>
			<br>

<!--Section 1.5-->
			<div class=" remove stepBox" id="custom_assistant_settings" style="width: 600px">
				<div class='stepCircle'>5</div>

				<h3 id='custom_heading' >Which Tasks Will This Custom Assistant Handle? <span class="hint--right hint--rounded hint--large" aria-label= "Identify which tasks the custom assistant can offlfrom the locomotive Dispatcher."><sup>(&#x003F;)</sup></span></h3>

				<br>
				<table class="pure-table" >
					<tr>
						<?php $custom_name = $_SESSION['assistants']['custom']['name']; ?>
						<th>Assistant Name:</td>
						<td><input type='text' name="custom_op_name" value="<?php if ($custom_name != 'custom') echo ucwords($custom_name); ?>"></input></td>
					</tr>
				<?php

					if (isset($_SESSION['assistants']['custom']))
						$custom_tasks = $_SESSION['assistants']['custom']['tasks'];
					else
						$custom_tasks = array();
					$task_names = array_keys($_SESSION['tasks']);

					$i = 0;
					foreach ($task_names as $task) {
						echo "<tr><td>" . ucwords($task) . " <span class='hint--right hint--rounded hint--large' aria-label= '".  $_SESSION['tasks'][$task]['description'] . "'>";
						echo '<sup>(?)</sup></span></td><td>';
						echo '<input type="checkbox" name="custom_op_task_' . $i . '"';
						// if ($key = array_search($task, $custom_tasks) !== false) echo ' checked';
						if (in_array($i++, $custom_tasks)) echo ' checked';
						echo '></input>';
						echo '</td></tr>';
					}
				?>
				</table>
			</div>
            <div class="trafficTableStepOuter stepBox centerOuter remove">
                <div class='stepCircle'>3</div>
                <h3 class="whiteFont">
                    What are the Traffic Levels?
                    <span class="hint--right hint--rounded hint--large" aria-label= "Enter the local levels of traffic during this shift. This will modify the frequency of certain task arrivals."><sup>(?)</sup></span>
                </h3>
                <div id="totalTime" style="overflow-x:auto;">
                    <table id='table' class='trafficTable remove'>
                        <?php
                        echo '<tr id="traffic_levels">';
                        $chars = ['h', 'm', 'l'];
                        $labels = ['High', 'Med', 'Low'];
                        for ($i = 0; $i < $_SESSION['parameters']['hours']; $i++) {
                            $val = $_SESSION['parameters']['traffic_chars'][$i];
                            echo '<td>';
                            for ($j = 0; $j < sizeof($labels); $j++) {
                                $selected = '';
                                if ($chars[$j] == $val) $selected = ' checked';
                                echo "<input type='radio' name='traffic_level_$i' value='$chars[$j]'$selected>$labels[$j]</input><br>";
                            }
                            echo '</td>';
                        }
                        echo '</tr>';
                        echo '<tr id="traffic_level_labels">';
                        echo '</tr>';
                        ?>
                    </table>
                    <!-- </div> -->

                </div>
            </div>

			<br>

		</div>

        <!-- FORM 2-->
        <div id="batch_2" class="formBox tabcontent" style="display: none">
            <h1 style="border-radius: 5px;padding:5px; margin: auto; font-family: 'Lucida Grande'; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); background-color: #639752; color: white">Sector 2</h1>

 <!-- Section 2.1-->
            <div class="startEndTime stepBox " style="margin-left: 0%" >
                <div class='stepCircle'>1</div>
                <h3 >How Many Trains in this Batch<span class="hint--bottom-right hint--rounded hint--large" aria-label= "Enter the time of day that your dispatcher begins his/her shift."><sup>(?)</sup></span></h3>
                <select name='num_reps'>
                    <?php
                    $tr = $_SESSION['parameters']['trains'];
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = '';
                        if ($i == $tr) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>
            </div>

  <!-- Section 2.2-->

            <div class="startEndTime stepBox " style="margin-left: 0%" >
                <div class='stepCircle'>2</div>
                <h3 >When Does This Batch Trip Begin? <span class="hint--bottom-right hint--rounded hint--large" aria-label= "Enter the time of day that your dispatcher begins his/her shift."><sup>(?)</sup></span></h3>
                <select id='beginHour' onchange="calculate_time();">
                    <?php
                    $hr = (int)substr($_SESSION['parameters']['begin'], 0, 2);
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = '';
                        if ($i == $hr) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>:<select id='beginMin' onchange="calculate_time();">
                    <?php
                    $min = (int)substr($_SESSION['parameters']['begin'], 3, 5);
                    for ($i = 0; $i <= 50; $i+=10) {
                        $selected = '';
                        if ($i == $min) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>
                <select id='beginMd' onchange="calculate_time();">
                    <?php
                    $options = ['AM', 'PM'];
                    $md = substr($_SESSION['parameters']['begin'], 6);
                    for ($i = 0; $i < sizeof($options); $i++) {
                        $selected = '';
                        if ($options[$i] == $md) $selected = ' selected="selected"';
                        echo "<option$selected>$options[$i]</option>";
                    }
                    ?>
                </select>
                <input id="begin_time" name="begin_time" type="hidden" value="<?php echo $_SESSION['parameters']['begin'];?>">
            </div>

<!-- Section 2.3-->
            <div class="startEndTime stepBox " style="margin-left: auto" >
                <div class='stepCircle'>3</div>
                <h3 >When Does This Batch Trip End? <span class="hint--bottom-left hint--rounded hint--large" aria-label= "Enter the time of day that your dispatcher is expected to end his/her shift."><sup>(?)</sup></span></h3>

                <select id='endHour' onchange="calculate_time();">
                    <?php
                    $hr = (int)substr($_SESSION['parameters']['end'], 0, 2);
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = '';
                        if ($i == $hr) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>:<select id='endMin' onchange="calculate_time();">
                    <?php
                    $min = (int)substr($_SESSION['parameters']['end'], 3, 5);
                    for ($i = 0; $i <= 50; $i+=10) {
                        $selected = '';
                        if ($i == $min) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>
                <select id='endMd' onchange="calculate_time();">
                    <?php
                    $options = ['AM', 'PM'];
                    $md = substr($_SESSION['parameters']['end'], 6);
                    for ($i = 0; $i < sizeof($options); $i++) {
                        $selected = '';
                        if ($options[$i] == $md) $selected = ' selected="selected"';
                        echo "<option$selected>$options[$i]</option>";
                    }
                    ?>
                </select>
                <input id="end_time" name="end_time" type="hidden" value="<?php echo $_SESSION['parameters']['end'];?>">
                <input id="num_hours" name="num_hours" type="hidden" value="<?php echo $_SESSION['parameters']['hours'];?>">
            </div>


<!--  Section 2.4-->
            <div class=" assistantsSelectStepOuter stepBox " >
                <div class='stepCircle'>4</div>
                <h3 id='assistants'>Who Will Assist the Engineer? <span class="hint--right hint--rounded hint--large" aria-label= "Identify any humans or technologies that will support the locomotive engineer. SHOW models their interaction by offloading certain tasks from the engineer."><sup>(?)</sup></span></h3>
                <div id="assist">
                    <table class="pure-table" id="assistantsTable" style="font-family: 'Lucida Grande'" >
                        <tr>
                            <?php
                            $assistant_names = array_keys($_SESSION['assistants']);
                            for ($i = 1; $i < sizeof($assistant_names); $i++) {
                                $assistant = $assistant_names[$i];
                                $selected = '';
                                if (in_array($assistant, $_SESSION['parameters']['assistants'])) {
                                    $selected = ' checked';
                                }
                                echo '<td><input ';
                                if ($assistant == 'custom') echo 'id="custom_assistant_2" onchange="toggle_custom_settings();"';
                                echo 'type="checkbox" name="assistant_' . $i  . '"'  . $selected . '>'  . ucwords($assistant) . ' ';
                                echo "<span class='hint--right hint--rounded hint--large' aria-label= '". $_SESSION['assistants'][$assistant]['description'] . "'><sup> (&#x003F;) </sup></span>";
                                echo '</td>';
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
 <!--Section 2.5-->
            <div class=" remove stepBox" id="custom_assistant_settings_2" style="width: 600px">
                <div class='stepCircle'>5</div>

                <h3 id='custom_heading' >Which Tasks Will This Custom Assistant Handle? <span class="hint--right hint--rounded hint--large" aria-label= "Identify which tasks the custom assistant can offlfrom the locomotive engineer."><sup>(&#x003F;)</sup></span></h3>

                <br>
                <table class="pure-table" >
                    <tr>
                        <?php $custom_name = $_SESSION['assistants']['custom']['name']; ?>
                        <th>Assistant Name:</td>
                        <td><input type='text' name="custom_op_name" value="<?php if ($custom_name != 'custom') echo ucwords($custom_name); ?>"></input></td>
                    </tr>
                    <?php

                    if (isset($_SESSION['assistants']['custom']))
                        $custom_tasks = $_SESSION['assistants']['custom']['tasks'];
                    else
                        $custom_tasks = array();
                    $task_names = array_keys($_SESSION['tasks']);

                    $i = 0;
                    foreach ($task_names as $task) {
                        echo "<tr><td>" . ucwords($task) . " <span class='hint--right hint--rounded hint--large' aria-label= '".  $_SESSION['tasks'][$task]['description'] . "'>";
                        echo '<sup>(?)</sup></span></td><td>';
                        echo '<input type="checkbox" name="custom_op_task_' . $i . '"';
                        // if ($key = array_search($task, $custom_tasks) !== false) echo ' checked';
                        if (in_array($i++, $custom_tasks)) echo ' checked';
                        echo '></input>';
                        echo '</td></tr>';
                    }
                    ?>
                </table>
            </div>
<!--            <input  class="pure-button pure-button-active " onclick="location.href='adv_settings.php';" style="color: black;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);" value="Operator Settings">-->
        </div>

        <!--FORM 3-->
        <div id="batch_3" class=" formBox tabcontent" style="display: none">
         <!-- Section 3.1-->
            <h1 style="border-radius: 5px;padding:5px; margin: auto; font-family: 'Lucida Grande'; background-color: #b9594b; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); color: white">Sector 3</h1>

            <div class="startEndTime stepBox " style="margin-left: 0%" >
                <div class='stepCircle'>2</div>
                <h3 >How Many Trains in this Batch<span class="hint--bottom-right hint--rounded hint--large" aria-label= "Enter the time of day that your dispatcher begins his/her shift."><sup>(?)</sup></span></h3>
                <select name='num_reps'>
                    <?php
                    $tr = $_SESSION['parameters']['trains'];
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = '';
                        if ($i == $tr) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>
            </div>
       <!-- Section 3.2-->
            <div class="startEndTime stepBox "style="margin-left: 0%" >
                <div class='stepCircle'>2</div>
                <h3>When Does This Batch Trip Begin? <span class="hint--bottom-right hint--rounded hint--large" aria-label= "Enter the time of day that your dispatcher begins his/her shift."><sup>(?)</sup></span></h3>
                <select id='beginHour' onchange="calculate_time();">
                    <?php
                    $hr = (int)substr($_SESSION['parameters']['begin'], 0, 2);
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = '';
                        if ($i == $hr) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>:<select id='beginMin' onchange="calculate_time();">
                    <?php
                    $min = (int)substr($_SESSION['parameters']['begin'], 3, 5);
                    for ($i = 0; $i <= 50; $i+=10) {
                        $selected = '';
                        if ($i == $min) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>
                <select id='beginMd' onchange="calculate_time();">
                    <?php
                    $options = ['AM', 'PM'];
                    $md = substr($_SESSION['parameters']['begin'], 6);
                    for ($i = 0; $i < sizeof($options); $i++) {
                        $selected = '';
                        if ($options[$i] == $md) $selected = ' selected="selected"';
                        echo "<option$selected>$options[$i]</option>";
                    }
                    ?>
                </select>
                <input id="begin_time" name="begin_time" type="hidden" value="<?php echo $_SESSION['parameters']['begin'];?>">
            </div>

            <!-- Section 3.3-->


            <div class="startEndTime stepBox " style="margin-left: auto" >
                <div class='stepCircle'>3</div>
                <h3 >When Does This Batch Trip End? <span class="hint--bottom-left hint--rounded hint--large" aria-label= "Enter the time of day that your dispatcher is expected to end his/her shift."><sup>(?)</sup></span></h3>

                <select id='endHour' onchange="calculate_time();">
                    <?php
                    $hr = (int)substr($_SESSION['parameters']['end'], 0, 2);
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = '';
                        if ($i == $hr) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>:<select id='endMin' onchange="calculate_time();">
                    <?php
                    $min = (int)substr($_SESSION['parameters']['end'], 3, 5);
                    for ($i = 0; $i <= 50; $i+=10) {
                        $selected = '';
                        if ($i == $min) $selected = ' selected="selected"';
                        $val = sprintf('%02d', $i);
                        echo "<option$selected>$val</option>";
                    }
                    ?>
                </select>
                <select id='endMd' onchange="calculate_time();">
                    <?php
                    $options = ['AM', 'PM'];
                    $md = substr($_SESSION['parameters']['end'], 6);
                    for ($i = 0; $i < sizeof($options); $i++) {
                        $selected = '';
                        if ($options[$i] == $md) $selected = ' selected="selected"';
                        echo "<option$selected>$options[$i]</option>";
                    }
                    ?>
                </select>
                <input id="end_time" name="end_time" type="hidden" value="<?php echo $_SESSION['parameters']['end'];?>">
                <input id="num_hours" name="num_hours" type="hidden" value="<?php echo $_SESSION['parameters']['hours'];?>">
            </div>
            <!--			</div>-->



            <!--  Section 3.4-->
            <div class=" assistantsSelectStepOuter stepBox " >
                <div class='stepCircle'>4</div>
                <h3 id='assistants'>Who Will Assist the Engineer? <span class="hint--right hint--rounded hint--large" aria-label= "Identify any humans or technologies that will support the locomotive engineer. SHADO models their interaction by offloading certain tasks from the engineer."><sup>(?)</sup></span></h3>
                <div id="assist">
                    <table class="pure-table" id="assistantsTable" style="font-family: 'Lucida Grande'" >
                        <tr>
                            <?php
                            $assistant_names = array_keys($_SESSION['assistants']);
                            for ($i = 1; $i < sizeof($assistant_names); $i++) {
                                $assistant = $assistant_names[$i];
                                $selected = '';
                                if (in_array($assistant, $_SESSION['parameters']['assistants'])) {
                                    $selected = ' checked';
                                }
                                echo '<td><input ';
                                if ($assistant == 'custom') echo 'id="custom_assistant_3" onchange="toggle_custom_settings();"';
                                echo 'type="checkbox" name="assistant_' . $i  . '"'  . $selected . '>'  . ucwords($assistant) . ' ';
                                echo "<span class='hint--right hint--rounded hint--large' aria-label= '". $_SESSION['assistants'][$assistant]['description'] . "'><sup> (&#x003F;) </sup></span>";
                                echo '</td>';
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <br>

            <!--Section 3.5-->
            <div class=" remove stepBox" id="custom_assistant_settings_3" style="width: 600px">
                <div class='stepCircle'>5</div>

                <h3 id='custom_heading' >Which Tasks Will This Custom Assistant Handle? <span class="hint--right hint--rounded hint--large" aria-label= "Identify which tasks the custom assistant can offlfrom the locomotive engineer."><sup>(&#x003F;)</sup></span></h3>

                <br>
                <table class="pure-table" >
                    <tr>
                        <?php $custom_name = $_SESSION['assistants']['custom']['name']; ?>
                        <th>Assistant Name:</td>
                        <td><input type='text' name="custom_op_name" value="<?php if ($custom_name != 'custom') echo ucwords($custom_name); ?>"></input></td>
                    </tr>
                    <?php

                    if (isset($_SESSION['assistants']['custom']))
                        $custom_tasks = $_SESSION['assistants']['custom']['tasks'];
                    else
                        $custom_tasks = array();
                    $task_names = array_keys($_SESSION['tasks']);

                    $i = 0;
                    foreach ($task_names as $task) {
                        echo "<tr><td>" . ucwords($task) . " <span class='hint--right hint--rounded hint--large' aria-label= '".  $_SESSION['tasks'][$task]['description'] . "'>";
                        echo '<sup>(?)</sup></span></td><td>';
                        echo '<input type="checkbox" name="custom_op_task_' . $i . '"';
                        // if ($key = array_search($task, $custom_tasks) !== false) echo ' checked';
                        if (in_array($i++, $custom_tasks)) echo ' checked';
                        echo '></input>';
                        echo '</td></tr>';
                    }
                    ?>
                </table>
            </div>


        </div>

        <!-- BOTTOM OF PAGE-->
        <div id="bottomNav" style="margin-left: 25%">
            <input  class="pure-button pure-button-active " name="adv_settings" onclick="location.href='adv_settings.php';" style="box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);color: black;" value="Operator Settings">
<!--<li>-->
            <li>

                    <div class="dropdown" >
                        <button  class="pure-button" type="submit" name="run_sim" style=" border-radius: 3px;  background-color: #4CAF50; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);">Run Simulation &#8680<span class="hint--right hint--rounded hint--large" aria-label= "the number of replications, or the number of simulated trips. Note that more trips provide more precise results, but it may also increase the processing time"><sup>(&#x003F;)</sup></span> </button>
                        <div class="dropdown-content">
                            <button type="submit" name="run_sim" <span>For 100 shifts</span></button>
                            <button type="submit" name="run_sim"><span>For 1000 shifts</span></button>
                            <button type="submit" name="run_sim" ><span>For 10000 shifts</span></button>
                        </div>
                        <input id="time_reps" name="time_rep" type="hidden" value="<?php echo $_SESSION['parameters']['reps'];?>">

                    </div>


        </div>
        </form>
	</div>

<?php require_once('includes/page_parts/footer.php');?>


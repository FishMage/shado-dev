
	<?php session_start();
	$keys=array_keys($type_byPhase);

	?>



	<div id="text_box" class="why_tab" style="display: none;">

			<h3 style="text-align: center;"> <u><em>Why</em> is my operator over or under-utilized at work? </u></h3><br>
			<ul><li >
			We simulated <?php echo $_SESSION['parameters']['reps']; ?> trips and plotted the mean value per interval of time. The model shows that <?php echo round($type_byPhase[$keys[0]]*100/$length,2); ?>% of the operator’s time can be attributed to <?php echo array_keys($_SESSION['tasks'])[$keys[0]-1]; ?>. <?php $taskName = array_keys($_SESSION['tasks']); $name = $taskName[$keys[0]-1];
			if(in_array($name,array_keys($_SESSION['default_tasks']))) {
			echo ucfirst($taskName[$keys[0]-1]); ?> involves <?php if($assistant=='engineer') { echo strtolower($_SESSION['tasks'][$name]['description']);} else{ echo strtolower($_SESSION[$name]['description'])."."; }} ?>
			</li><br><li >
			 <?php $taskName = array_keys($_SESSION['tasks']); if(in_array($taskName[$keys[1]-1], array_keys($_SESSION['default_tasks']))){ if($assistant=='engineer'){echo $_SESSION['tasks'][$taskName[$keys[1]-1]]['description'];} else{ echo $_SESSION[$taskName[$keys[1]-1]]['description'];} ?> makes <?php echo $taskName[$keys[1]-1]; ?> an important secondary task that accounts for <?php echo round($type_byPhase[$keys[1]]*100/$length,2); ?>% of their total time on task.
			 <?php } else{ echo ucfirst($taskName[$keys[1]-1]);?> is an important secondary task that accounts for <?php echo round($type_byPhase[$keys[1]]*100/$length,2); ?>% of their total time on task.
			 <?php } ?>

			</li><br>
			<?php if($count_high>0){
					if($count_low>0){ ?>
						<li >During this trip, the operator spent approximately <?php echo round($count_high*100/$length,2); ?>% of time at or above a high level of workload (>70% utilization) and <?php echo round($count_low*100/$length,2); ?> % with too little work  (<30% utilization). </li>
					<?php }
					else{ ?>
						<li>During this trip, the operator spent approximately <?php echo round($count_high*100/$length,2); ?>% of time at or above a high level of workload (>70% utilization).</li>l
						<?php } }
					else{
						if($count_low>0){ ?>
						<li>During this trip, the operator spent approximately <?php echo round($count_low*100/$length,2); ?>% of time at or below a low level of workload (<30% utilization). </li>
			<?php } } ?></ul>

			<?php if(max(array_values($count_type_high))>0) { ?>
			<h3>These combined factors <em>significantly</em> contributed to period of high workload: </h3>
			<ul>
			<?php

			$high_keys = array_keys($count_type_high);
			for($j=1;$j<6;$j++)
			{
				if((($type_byPhase[$high_keys[$j-1]])>0) && ($count_type_high[$high_keys[$j-1]]>0))
				{
					echo "<li onclick='display" . ($high_keys[$j-1]-1) ."();' style='cursor: pointer; cursor: hand;' class='list'>". ucwords(array_keys($_SESSION['tasks'])[$high_keys[$j-1]-1]) ."<ul id='high". ($high_keys[$j-1]-1) . "'>";

					if($count_type_high1[$high_keys[$j-1]]>0){
						if(array_sum($type_byPhase1[$high_keys[$j-1]])==0)
							{
								echo "<li>During Phase 1, your "  .$assistant. " spent 0% time on ". array_keys($_SESSION['tasks'])[$high_keys[$j-1]-1] ."</li>";
							}
						else{
							echo "</li>During Phase 1, your ".$assistant. " spent ". round(array_sum($type_byPhase1[$high_keys[$j-1]])*100/$length_phase1,2) ."% time on ". array_keys($_SESSION['tasks'])[$high_keys[$j-1]-1] ."</li>";

						}
					}

					if($count_type_high2[$high_keys[$j-1]]>0){
						if(array_sum($type_byPhase2[$high_keys[$j-1]])==0){
							echo "<li>During Phase 2, your " .$assistant. " spent 0% time on ". array_keys($_SESSION['tasks'])[$high_keys[$j-1]-1] ."</li>";
						}
						else{
							echo "<li>During Phase 2, your " .$assistant. " spent ". round(array_sum($type_byPhase2[$high_keys[$j-1]])*100/$length_phase2,2) ."% time on ". array_keys($_SESSION['tasks'])[$high_keys[$j-1]-1] ."</li>";
						}
					}

					if($count_type_high3[$high_keys[$j-1]]>0){
						if(array_sum($type_byPhase3[$high_keys[$j-1]])==0){
							echo "<li>During Phase 3, your " .$assistant. " spent 0% time on ". array_keys($_SESSION['tasks'])[$high_keys[$j-1]-1] ."</li>";
						}
						else{
							echo "<li>During Phase 3, your " .$assistant. " spent ". round(array_sum($type_byPhase3[$high_keys[$j-1]])*100/$length_phase3,2) ."% time on ". array_keys($_SESSION['tasks'])[$high_keys[$j-1]-1] ."</li>";
						}
					}
					echo "</ul></li>";
				}
			}
			echo "</ul>" ;
			?>


		<br><br><br>
			<?php } ?>
		<?php if(max(array_values($count_type_low))>0) { ?>
		<h3>These combined factors <em>significantly</em> contributed to period of low workload: </h3>
		<ul>

<?php
	$low_keys = array_keys($count_type_low);
	for($j=1;$j<6;$j++)
	{
		if((($type_byPhase[$low_keys[$j-1]])>0) && ($count_type_low[$low_keys[$j-1]]>0))
		{
			echo "<li onclick='display" . ($low_keys[$j-1]-1) ."();' style='cursor: pointer; cursor: hand;' class='list'>". ucwords(array_keys($_SESSION['tasks'])[$low_keys[$j-1]-1]) ."<ul id='low". ($low_keys[$j-1]-1) . "'>";

			if($count_type_low1[$low_keys[$j-1]]>0){
				if(array_sum($type_byPhase1[$low_keys[$j-1]])==0)
					{
						echo "<li>During Phase 1, your " .$assistant. " spent 0% time on ". array_keys($_SESSION['tasks'])[$low_keys[$j-1]-1] ."</li>";
					}
				else{
					echo "<li>During Phase 1, your " .$assistant. " spent ". round(array_sum($type_byPhase1[$low_keys[$j-1]])*100/$length_phase1,2) ."% time on ". array_keys($_SESSION['tasks'])[$low_keys[$j-1]-1] ."</li>";

				}
			}

			if($count_type_low2[$low_keys[$j-1]]>0){
				if(array_sum($type_byPhase2[$low_keys[$j-1]])==0){
					echo "<li>During Phase 2, your " .$assistant. " spent 0% time on ". array_keys($_SESSION['tasks'])[$low_keys[$j-1]-1] ."</li>";
				}
				else{
					echo "<li>During Phase 2, your " .$assistant. " spent ". round(array_sum($type_byPhase2[$low_keys[$j-1]])*100/$length_phase2,2) ."% time on ". array_keys($_SESSION['tasks'])[$low_keys[$j-1]-1] ."</li>";
				}
			}

			if($count_type_low3[$low_keys[$j-1]]>0){
				if(array_sum($type_byPhase3[$low_keys[$j-1]])==0){
					echo "<li>During Phase 3, your " .$assistant. " spent 0% time on ". array_keys($_SESSION['tasks'])[$low_keys[$j-1]-1] ."</li>";
				}
				else{
					echo "<li>During Phase 3, your " .$assistant. " spent ". round(array_sum($type_byPhase3[$low_keys[$j-1]])*100/$length_phase3,2) ."% time on ". array_keys($_SESSION['tasks'])[$low_keys[$j-1]-1] ."</li>";
				}
			}
			echo "</ul></li>";
		}
	}
	echo "</ul>" ;
?>
 <?php } ?>
	<br><br><br>
	<?php
		$check=0;
		$id=0;
		$traffic = $_SESSION['parameters']['traffic_nums'];
		if(array_sum(array_slice($traffic,0,$_SESSION['parameters']['hours']/2))>=array_sum(array_slice($traffic,$_SESSION['parameters']['hours']/2,$_SESSION['parameters']['hours']))){
			for($i=2+$length/2;$i<$num;$i++){
				if($count[10][$i]>0.7){
					$check=1.0;
					$id=$i-2;
					break;
				}
			}

			if($check==1){
				$util_first=array_sum(array_slice($count[10],1,$length/2+1));
				$util_second=array_sum(array_slice($count[10],$length/2+1,$length));
				if($util_second>$util_first){
	?>
	<h3 style="color: red">Fatigue factor!</h3>
	From <b> <?php echo $id*10; ?>th </b>minute, your <?php echo $assistant;?>’s fatigue began to
    contribute to higher than normal workload
	<?php
			}
		}
	}
	?>

</div>

<?php echo "</div>"; ?>

<?php
 echo "<style>";

 for($j=1;$j<$temp_count-1;$j++)
	{
		if($count_type_low[$low_keys[$j-1]]>0)
		{
			echo "#low". ($low_keys[$j-1]-1)."{ display: block;}";
		}
	}

	for($j=1;$j<$temp_count-1;$j++)
	{
		if($count_type_high[$high_keys[$j-1]]>0)
		{
			echo "#high". ($high_keys[$j-1]-1)."{ display: block;}";
		}
	}
 echo "</style>";
?>

<script>

<?php
	for($j=1;$j<$temp_count-1;$j++)
		{
			if($count_type_low[$low_keys[$j-1]]>0)
		{
?>
	function display<?php echo ($low_keys[$j-1]-1) ;?>(){

			if(document.getElementById('<?php echo 'low'. ($low_keys[$j-1]-1); ?>').style.display=='none')
			{
				document.getElementById('<?php echo 'low'. ($low_keys[$j-1]-1); ?>').style.display='block';
			}
			else{
				document.getElementById('<?php echo 'low'. ($low_keys[$j-1]-1); ?>').style.display='none';
			}
		}
<?php
	}
}

		for($j = 1; $j<$temp_count-1;$j++)
		{
			if($count_type_high[$high_keys[$j-1]]>0)
		{
?>
	function display<?php echo ($high_keys[$j-1]-1) ;?>(){

			if(document.getElementById('<?php echo 'high'. ($high_keys[$j-1]-1); ?>').style.display=='none')
			{
				document.getElementById('<?php echo 'high'. ($high_keys[$j-1]-1); ?>').style.display='block';
			}
			else{
				document.getElementById('<?php echo 'high'. ($low_keys[$j-1]-1); ?>').style.display='none';
			}
		}
<?php
	}
	}
?>
</script>

<style>
	.list{
		padding:5px 15px;
		border: 2px solid #5D7B85;
		cursor:pointer;
		-webkit-border-radius: 5px;
		border-radius: 25px;
		width:fit-content;
		width:-webkit-fit-content;
		width:-moz-fit-content;
		/*margin: 0 auto;*/
		margin: 20px;
		text-align: left;
		background-color: rgba(255, 255, 255, 0.6);
		overflow: auto;
	}
</style>

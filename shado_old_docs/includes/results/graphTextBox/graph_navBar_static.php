<?php

	function graphTextStatic($fname){

		session_start();
// <<<<<<< HEAD
//
// 		$file_handle = fopen($fname,'r');
// 		$count = array();
// 		$temp_count = 0;
// 		$skip = 1;
// 		$num = 0;
//
// 		while (!feof($file_handle)) {
// 			if($temp_count==1) {
// =======
		$traffic=array();
		if(isset($_SESSION['traffic_time'])){
			$time=$_SESSION['traffic_time'];
			for($i=0;$i<$time;$i++){
				$traffic[$i]=$_SESSION['traffic_level'][$i];
			}
		}

		$file_handle = fopen($fname,'r');
		$count = array();
		$temp_count=0;
		$skip=1;
		$num=0;

		while (! feof($file_handle))
		{
			if($temp_count==1)
			{
// >>>>>>> 7f0fb161ef371c8638e485226d441e876059a563
				$skip=1;
			}

			$line_of_text = fgetcsv($file_handle,2048,',');

			if($line_of_text[0]=="Service Time")
			{
				break;
			}

			if($skip==1)
			{
				$num=count($line_of_text);
				$count[$temp_count]=array();
				for($i=1;$i<$num;$i++)
				{
					if($temp_count==0)
					{
						$count[$temp_count][$i-1]=$line_of_text[$i];
					}
					else
					{
						$count[$temp_count][$i-1]=(float)$line_of_text[$i];
					}

				}
				$skip=0;
				$temp_count++;
				continue;
			}

			if($skip==0)
			{
				$skip=1;
				continue;
			}
		}

		fclose($file_handle);

		$type_byPhase1=array();
		$type_byPhase2=array();
		$type_byPhase3=array();
		$type_byPhase=array();

		for($j=1;$j<$temp_count-1;$j++)
		{
			$type_byPhase1[$j]=array();
			$type_byPhase2[$j]=array();
			$type_byPhase3[$j]=array();
			$type_byPhase[$j]=0;

			for($i=1;$i<$num-1;$i++)
			{
				if($i<4)
				{
					/* $type_byPhase1[$j][]=$count[$j][$i]; */
					array_push($type_byPhase1[$j], $count[$j][$i]);
					$type_byPhase[$j]=$type_byPhase[$j]+$count[$j][$i];
/* 					array_push($type_byPhase[$j], $count[$j][$i]);
 */				}
				else
				{
					if($i>($num-5))
					{
						array_push($type_byPhase3[$j], $count[$j][$i]);
						$type_byPhase[$j]=$type_byPhase[$j]+$count[$j][$i];
					}
					else
					{
						array_push($type_byPhase2[$j], $count[$j][$i]);
						$type_byPhase[$j]=$type_byPhase[$j]+$count[$j][$i];
					}
				}
			}
		}

		$count_type_high1=array();
		$count_type_high2=array();
		$count_type_high3=array();
		$count_type_low1=array();
		$count_type_low2=array();
		$count_type_low3=array();

		$count_type_low=array();
		$count_type_high=array();

		$length=$num-2;

		$length_phase1=3;
		$length_phase2=$length-6;
		$length_phase3=3;



		for($j=1;$j<$temp_count-1;$j++)
		{
			$count_type_high1[$j]=0;
			$count_type_low1[$j]=0;
			$count_type_high2[$j]=0;
			$count_type_low2[$j]=0;
			$count_type_high3[$j]=0;
			$count_type_low3[$j]=0;
			$count_type_high[$j]=0;
			$count_type_low[$j]=0;
		}

		for($i=1;$i<$num-1;$i++)
		{
			for($j=1;$j<$temp_count-1;$j++)
			{
				if($count[$temp_count-1][$i]>0.7)
				{
					if($i<4)
					{
						if($count[$j][$i]>(array_sum($type_byPhase1[$j])/count($type_byPhase1[$j])))
						{
							$count_type_high1[$j]++;
							$count_type_high[$j]++;
						}
					}
					else
					{
						if($i>($num-5))
						{
							if($count[$j][$i]>(array_sum($type_byPhase3[$j])/count($type_byPhase3[$j])))
							{
								$count_type_high3[$j]++;
								$count_type_high[$j]++;
							}
						}
						else
						{
							if($count[$j][$i]>(array_sum($type_byPhase2[$j])/count($type_byPhase2[$j])))
							{
								$count_type_high2[$j]++;
								$count_type_high[$j]++;
							}
						}
					}
					continue;
				}

				if($count[$temp_count-1][$i]<0.3)
				{
					if($i<4)
					{
						if($count[$j][$i]<(array_sum($type_byPhase1[$j])/count($type_byPhase1[$j])))
						{
							$count_type_low1[$j]++;
							$count_type_low[$j]++;
						}
					}
					else
					{
						if($i>($num-5))
						{
							if($count[$j][$i]<(array_sum($type_byPhase3[$j])/count($type_byPhase3[$j])))
							{
								$count_type_low3[$j]++;
								$count_type_low[$j]++;
							}
						}
						else
						{
							if($count[$j][$i]<(array_sum($type_byPhase2[$j])/count($type_byPhase2[$j])))
							{
								$count_type_low2[$j]++;
								$count_type_low[$j]++;
							}
						}
					}
					continue;
				}
			}
		}

		arsort($count_type_low);
		arsort($count_type_high);
		arsort($type_byPhase);
		// print_r($count[10]);

		$count_ops=0;
		for($i=1;$i<5;$i++)
		{
			if(isset($_SESSION['operator'.$i]))
				{
					if($_SESSION['operator'.$i]==1){
						$count_ops++;
					}
				}

		}

		$penalty_high=0;
		$count_high=0;
		$count_low=0;
		$count_norm=0;
		for($i=1;$i<$num-1;$i++)
		{
			if($count[$temp_count-1][$i]>0.7)
			{
				$penalty_high=$penalty_high+(3.33*$count[$temp_count-1][$i]-2.33);
				$count_high++;

			}
			else{
				if($count[$temp_count-1][$i]<0.3){
					$count_low++;
				}
				else{$count_norm++;}
			}

		}

		if ($count_high != 0)
			$penalty_high=$penalty_high/$count_high;
		else
			$penalty_high = 0;

		if ($fname == $_SESSION['session_dir'] . 'stats_engineer.csv') {
			$assistant='engineer';
		} else {
			$assistant='conductor';
		}

		echo "<br><br><br><br><br><br>

		<div id='graphTextBox' class='no-page-break'>
			<nav id='graphNav'>
				<ul>
					<li style='background-color: #75D3FE ;'>When?</li>
					<li style='background-color: #f1f1f1 ;'>Why?</li>
				</ul>
			</nav>";
		include("includes/results/graphTextBox/graph_whenTab.php");

		echo "</div><br><br><br><br><br><br>

		<div id='graphTextBox' class='no-page-break'>
			<nav id='graphNav'>
				<ul>
					<li style='background-color: #f1f1f1;'>When?</li>
					<li style='background-color: #75D3FE ;'>Why?</li>
				</ul>
			</nav>";
		include("includes/results/graphTextBox/graph_whyTab.php");
		



	}
?>

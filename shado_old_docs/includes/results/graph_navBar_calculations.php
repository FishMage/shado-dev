<?php

	function graphText($file_name) {

		session_start();

		$file = fopen($file_name,'r') or die("Could not open $file_name! Please return to check and update your settings.");
		$count = array();
		$temp_count = 1;
		$skip = 1;
		$num = 0;

		while ($temp_count <= count($_SESSION['tasks']) + 1) {

            $line_of_data = fgetcsv($file, 2048, ',');
//            foreach($line_of_data as $da){
//            	echo $da . " ";
//			}
//			echo "    RARARARASPUTIN    ";
            $num = count($line_of_data);
            $count[$temp_count] = array();
            for ($i = 1; $i< $num; $i++){
            	$count[$temp_count][0] = (float)$temp_count - 1;
                $count[$temp_count][$i] = (float)$line_of_data[$i-1];
                if($skip == 1){
                    $count[0][$i] = (string)(($i-1)*10) . " min";
                }
            }

            $skip = 0;
            $temp_count++;

//			if($temp_count==1) {
//				$skip=1;
//			}
//
//			$line_of_text = fgetcsv($file,2048,',');
//
//			if($line_of_text[0] == "Service Time") {
//				break;
//			}
//
//			if($skip==1) {
//				$num = count($line_of_text);
//				$count[$temp_count] = array();
//				for ($i = 1; $i < $num; $i++) {
//					if($temp_count==0) {
//						$count[$temp_count][$i-1]=$line_of_text[$i];
//					} else {
//						$count[$temp_count][$i-1]=(float)$line_of_text[$i];
//					}
//				}
//
//				$skip = 0;
//				$temp_count++;
//				continue;
//			}
//
//			if ($skip == 0) {
//				$skip = 1;
//				continue;
//			}
		}

		fclose($file);

//		echo var_dump($count);

		$type_byPhase1 = array();
		$type_byPhase2 = array();
		$type_byPhase3 = array();
		$type_byPhase = array();

// 		for($j = 1; $j < $temp_count - 1; $j++) {
//
// <<<<<<< HEAD
// 			$type_byPhase1[$j] =array();
// 			$type_byPhase2[$j] = array();
// 			$type_byPhase3[$j] = array();
// 			$type_byPhase[$j] = array();
// =======
		for($j=1;$j<$temp_count-1;$j++)
		{
			$type_byPhase1[$j]=array();
			$type_byPhase2[$j]=array();
			$type_byPhase3[$j]=array();
			$type_byPhase[$j]=0;
// >>>>>>> 7f0fb161ef371c8638e485226d441e876059a563

			for ($i = 1; $i < $num - 1; $i++) {
				if ($i < 4) {
					/* $type_byPhase1[$j][]=$count[$j][$i]; */
					array_push($type_byPhase1[$j], $count[$j][$i]);
// <<<<<<< HEAD
// 					array_push($type_byPhase[$j], $count[$j][$i]);
// 				} else {
// 					if ($i > ($num - 5)) {
// 						array_push($type_byPhase3[$j], $count[$j][$i]);
// 						array_push($type_byPhase[$j], $count[$j][$i]);
// 					} else {
// =======
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
// >>>>>>> 7f0fb161ef371c8638e485226d441e876059a563
						array_push($type_byPhase2[$j], $count[$j][$i]);
						$type_byPhase[$j]=$type_byPhase[$j]+$count[$j][$i];
					}
				}
			}
		}

		$count_type_high1 = array();
		$count_type_high2 = array();
		$count_type_high3 = array();
		$count_type_low1 = array();
		$count_type_low2 = array();
		$count_type_low3 = array();

		$count_type_low = array();
		$count_type_high = array();

		$length = $num - 2;

		$length_phase1 = 3;
		$length_phase2 = $length - 6;
		$length_phase3 = 3;

		for($j = 1; $j < $temp_count - 1; $j++) {
			$count_type_high1[$j] = 0;
			$count_type_low1[$j] = 0;
			$count_type_high2[$j] = 0;
			$count_type_low2[$j] = 0;
			$count_type_high3[$j] = 0;
			$count_type_low3[$j] = 0;
			$count_type_high[$j] = 0;
			$count_type_low[$j] = 0;
		}

		for($i = 1; $i < $num - 1; $i++) {
			for ($j = 1; $j < $temp_count - 1; $j++) {
				if ($count[$temp_count-1][$i] > 0.7) {
					if ($i < 4) {
						if ($count[$j][$i] > (array_sum($type_byPhase1[$j])/count($type_byPhase1[$j]))) {
							$count_type_high1[$j]++;
							$count_type_high[$j]++;
						}
					} else {
						if ($i > ($num - 5)) {
							if($count[$j][$i]>(array_sum($type_byPhase3[$j])/count($type_byPhase3[$j]))) {
								$count_type_high3[$j]++;
								$count_type_high[$j]++;
							}
						} else {
							if ($count[$j][$i] > (array_sum($type_byPhase2[$j])/count($type_byPhase2[$j]))) {
								$count_type_high2[$j]++;
								$count_type_high[$j]++;
							}
						}
					}
					continue;
				}

				if ($count[$temp_count-1][$i] < 0.3) {
					if ($i < 4) {
						if($count[$j][$i] < (array_sum($type_byPhase1[$j])/count($type_byPhase1[$j]))) {
							$count_type_low1[$j]++;
							$count_type_low[$j]++;
						}
					} else {
						if ($i > ($num - 5)) {
							if ($count[$j][$i] < (array_sum($type_byPhase3[$j])/count($type_byPhase3[$j]))) {
								$count_type_low3[$j]++;
								$count_type_low[$j]++;
							}
						} else {
							if ($count[$j][$i] < (array_sum($type_byPhase2[$j])/count($type_byPhase2[$j]))) {
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
// <<<<<<< HEAD
//
// 		$count_ops = 0;
// 		for ($i = 1; $i < 5; $i++) {
// 			if (isset($_SESSION['operator'.$i])) {
// 					if ($_SESSION['operator'.$i] == 1) {
// =======
		arsort($type_byPhase);

		// print_r($count[10]);

		$count_ops=0;
		for($i=1;$i<5;$i++)
		{
			if(isset($_SESSION['operator'.$i]))
				{
					if($_SESSION['operator'.$i]==1){
// >>>>>>> 7f0fb161ef371c8638e485226d441e876059a563
						$count_ops++;
					}
				}
		}

		$penalty_high = 0;
		$count_high = 0;
		$count_low = 0;
		$count_norm = 0;
		for ($i = 1; $i < $num - 1; $i++) {
			if ($count[$temp_count-1][$i] > 0.7) {
				$penalty_high = $penalty_high + (3.33 * $count[$temp_count-1][$i] - 2.33);
				$count_high++;
			} else {
				if ($count[$temp_count-1][$i] < 0.3) {
					$count_low++;
				} else {
					$count_norm++;
				}
			}
		}

		if ($count_high < 0)
			$penalty_high = $penalty_high/$count_high;
		else
			$penalty_high = 0;

		if ($file_name == $_SESSION['session_dir'] . 'engineer.csv') {
			$assistant = 'engineer';
		} else {
			$assistant = 'conductor';
		}

		require_once('includes/results/graphTextBox/graph_navBar.php');
		require_once('includes/results/graphTextBox/graph_whenTab.php');
		require_once('includes/results/graphTextBox/graph_whyTab.php');
	}
?>

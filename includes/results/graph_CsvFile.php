<?php
	session_start();

	function createGraphCsv($assistant) {

		$file = fopen($_SESSION['session_dir'] . "$assistant.csv", 'r') or die("Could not find $assistant file! Please return to check and update your settings.");
		$d3_file = fopen($_SESSION['session_dir'] . "mod_type_data_$assistant.txt", 'w') or die ("Could not open $assistant file! Please return to check and update your settings.");

		$count=array();
		$s_dev=array();
		$temp_count_dev=0;
		$temp_count=1;
		$skip=1;
		$num=0;

		while ($temp_count < count($_SESSION['tasks'])+1)
		{

			$line_of_data = fgetcsv($file, 2048, ',');
            $num = count($line_of_data);
            $count[$temp_count] = array();
            for ($i = 1; $i< $num; $i++){
            	$count[$temp_count][$i] = (float)$line_of_data[$i-1];
            	if($skip == 1){
            		$count[0][$i] = (string)(($i-1)*10) . " min";
				}
			}

			$skip = 0;

            $temp_count++;

//			if($temp_count==1)
//			{
//				$skip=1;
//			}
//			$line_of_text = fgetcsv($file,2048,',');
//			if($line_of_text[1]=="Sum")
//			{
//				break;
//			}
//			if($skip==1)
//			{
//				$num=count($line_of_text);
//				$count[$temp_count]=array();
//				for($i=1;$i<$num;$i++)
//				{
//					if($temp_count==0)
//					{
//						$count[$temp_count][$i-1]=$line_of_text[$i];
//					}
//					else
//					{
//						$count[$temp_count][$i-1]=(float)$line_of_text[$i];
//					}
//
//				}
//				$skip=0;
//				$temp_count++;
//				continue;
//			}
//			if($skip==0)
//			{
//				$num=count($line_of_text);
//				$s_dev[$temp_count_dev]=array();
//				for($i=2;$i<$num;$i++)
//				{
//					// $s_dev[$type_names[$temp_count_dev]][$count[0][$i-1]]=(float)$line_of_text[$i];
//					$s_dev[array_keys($_SESSION['tasks'])[$temp_count_dev]][$count[0][$i-1]]=(float)$line_of_text[$i];	// Fix
//				}
//				$temp_count_dev++;
//				$skip=1;
//				continue;
//			}
		}

		fclose($file);
		$count[0][0]='time';

		$taskNames = array_keys($_SESSION['tasks']);
		for($i=0;$i<$temp_count-1; $i++) {
            $count[$i + 1][0] = ucwords($taskNames[$i]);    // fix
        }

//        echo var_dump($count);
//		echo "Here's the num:   " . $num;

        for($i=0;$i<$num;$i++)
		{
			for($j=0;$j<$temp_count-1;$j++)
			{
				fwrite($d3_file,$count[$j][$i].",");
			}
			fwrite($d3_file,$count[$temp_count-1][$i]."\n");
		}

		fclose($d3_file);

		$_SESSION['n_columnsCsv']=$num;
		echo "<script>d3_visual('" . ucwords($assistant) . "'," . (string)$num . ", 'mod_type_data_" . strtolower($assistant) . ".txt')</script>";
	}
?>

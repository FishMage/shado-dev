<?php
	session_start();

	$low_count_0 = $_SESSION['low_count_0'];
	$normal_count_0 = $_SESSION['normal_count_0'];
	$high_count_0 = $_SESSION['high_count_0'];

    $low_count_2 = $_SESSION['low_count_2'];
    $normal_count_2 = $_SESSION['normal_count_2'];
    $high_count_2 = $_SESSION['high_count_2'];

	if (!in_array('conductor', $_SESSION['parameters']['assistants'])) {
		$operator2Style = 'display:none; ';
		$low_count_1 = 0;
		$normal_count_1 = 0;
		$high_count_1 = 0;
	} else {
		$operator2Style = ' ';
		$low_count_1 = $_SESSION['low_count_1'];
		$normal_count_1 = $_SESSION['normal_count_1'];
		$high_count_1 = $_SESSION['high_count_1'];;
	}
?>

<style>
	#low_work_0 {
		color:
		<?php
			if(($low_count_0+$high_count_0)>$normal_count_0) {
				if($low_count_0>$high_count_0) {
					echo "red";
				} else {
					echo "black";
				}
			} else {
				echo "black";
			}
		?>;
	}
	#normal_work_0{
		color:
		<?php
			if(($low_count_0+$high_count_0)<$normal_count_0) {
				echo "green";
			} else {
				echo "black";
			}
		?>;
	}
	#high_work_0 {
		color:
		<?php
			if(($low_count_0+$high_count_0)>$normal_count_0) {
				if($high_count_0>$low_count_0) {
					echo "red";
				} else {
					echo "black";
				}
			} else {
				echo "black";
			}
		?>;
	}

	#low_work_1 {
		color:
		<?php
			if(($low_count_1+$high_count_1)>$normal_count_1) {
				if($low_count_1>$high_count_1) {
					echo "red";
				} else {
					echo "black";
				}
			} else {
				echo "black";
			}
		?>;
	}

	#normal_work_1 {
		color:
		<?php
			if(($low_count_1+$high_count_1)<$normal_count_1){
				echo "green";
			} else {
				echo "black";
			}
		?>;
	}

	#high_work_1 {
		color:
		<?php
			if(($low_count_1+$high_count_1)>$normal_count_1) {
				if($high_count_1>$low_count_1) {
					echo "red";
				} else {
					echo "black";
				}
			} else {
				echo "black";
			}
		?>;
	}
</style>

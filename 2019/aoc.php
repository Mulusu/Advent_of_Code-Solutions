<?php
	foreach(range(1,25) as $day){
		$codefile = "days/day".$day.".php";
		if (!file_exists($codefile)){
			echo "No code for day $day \n";
			continue;
		}
		$input = file_get_contents("inputs/input".$day.".txt");
		if ($input == false) {
			echo 'Failed to load input for day ' . $day . ', QUITTING!\n';
			continue;
		}
		$answers = include($codefile);
		echo "DAY" . $day . ": " . $answers . "\n";
	}
?>

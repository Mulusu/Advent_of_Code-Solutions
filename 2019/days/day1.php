<?php
	$answer1 = 0;
	$answer2 = 0;
	$parts = explode("\n", trim($input));

	foreach($parts as $part){
		$fuel = floor($part / 3) - 2;
		$answer1 += (int)$fuel;
		while($fuel > 0){
			$answer2 += (int)$fuel;
			$fuel = floor($fuel/3) -2;
		}
	}
	return 'Part1: ' . $answer1 . ', Part2: ' . $answer2;
?>

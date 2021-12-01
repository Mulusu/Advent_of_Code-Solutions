<?php
	$answer1 = "";
	$answer2 = "";
	$numbers = explode("\n", trim($input));

	foreach( $numbers as $num1 ){
		$num1 = (int)$num1;
		foreach( $numbers as $num2){
			$num2 = (int)$num2;
			if($num1 + $num2 == 2020 and $num1 != $num2){
				$answer1 = $num1 * $num2;
			}
			foreach( $numbers as $num3){
				$num3 = (int)$num3;
				if($num1 + $num2 + $num3 == 2020 and $num1 != $num2 and $num1 != $num3 and $num2 != $num3){
					$answer2 = $num1 * $num2 * $num3;
				}
			}
		}
	}
	return 'Part1: ' . $answer1 . ', Part2: ' . $answer2;
?>

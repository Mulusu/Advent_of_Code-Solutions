<?php
$answer1 = "";
$answer2 = "";

function day2_intop(string $input, int $op1, int $op2){
	$codes = explode(",", trim($input));
	$codes[1] = $op1;
	$codes[2] = $op2;
	$done = false;
	for($i = 0; !$done; ){
		$code = $codes[$i];
		switch ($code){
			case 1:
				$codes[$codes[$i+3]] = $codes[$codes[$i+1]] + $codes[$codes[$i+2]];
				$i += 4;
				break;
			case 2:
				$codes[$codes[$i+3]] = $codes[$codes[$i+1]] * $codes[$codes[$i+2]];
				$i += 4;
				break;
			case 99:
				$done = true;
				break;
		}
	}
	return $codes[0];
}

$answer1 = day2_intop($input, 12,2);

$target = 19690720;
$done = false;
foreach(range(0,99) as $op1){
	foreach(range(0,99) as $op2){
		if(day2_intop($input,$op1,$op2) == $target){
			$answer2 = $op1 * 100 + $op2;
			$done = true;
		}
	}
}

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

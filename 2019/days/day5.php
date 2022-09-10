<?php
$answer1 = "";
$answer2 = "";

function day5_intop(string $input, int $op){
	$codes = explode(",", trim($input));
	$done = false;
	for($i = 0; !$done; ){
		if($i > count($codes)){
			echo 'Out of bounds! '.$i.' '.$num1.' '.$num2."\n"; 
			return false;
		}
		$num1 = 0;
		$num2 = 0;
		$code = ((strlen($codes[$i]) >= 3) ? substr($codes[$i],-2) : $codes[$i]);
		if($code != 3 and $code != 99){
			$num1 = ((strlen($codes[$i]) >= 3 and $codes[$i][-3] == "1") ? $codes[$i+1] : $codes[$codes[$i+1]]);
		}
		if($code != 3 and $code != 4 and $code != 99){
			$num2 = ((strlen($codes[$i]) >= 4 and $codes[$i][-4] == "1") ? $codes[$i+2] : $codes[$codes[$i+2]]);
		}
		switch ($code){
			case 1:
				$codes[$codes[$i+3]] = (string)($num1 + $num2);
				$i += 4;
				break;
			case 2:
				$codes[$codes[$i+3]] = (string)($num1 * $num2);
				$i += 4;
				break;
			case 3:
				$codes[$codes[$i+1]] = (string)$op;
				$i += 2;
				break;
			case 4:
				$answer = $num1;
				$i += 2;
				break;
			case 5:
				if($num1 != 0){
					$i = intval($num2);
				} else{
					$i += 3;
				}
				break;
			case 6:
				if($num1 == 0){
					$i = intval($num2);
				} else{
					$i += 3;
				}
				break;
			case 7:
				$codes[$codes[$i+3]] = (($num1 < $num2) ? 1 : 0);
				$i += 4;
				break;
			case 8:
				$codes[$codes[$i+3]] = (($num1 == $num2) ? 1 : 0);
				$i += 4;
				break;
			case 99:
				$done = true;
				break;
			default:
				echo "BORKEN at $i: ".$code." ".$num1." ".$num2;
				return;
		}
	}
	return $answer;
}
$answer1 = day5_intop($input, 1);
//$debug = "3,21,1008,21,8,20,1005,20,22,107,8,21,20,1006,20,31,1106,0,36,98,0,0,1002,21,125,20,4,20,1105,1,46,104,999,1105,1,46,1101,1000,1,20,4,20,1105,1,46,98,99";
//$answer2 = day5_intop($debug, 50);
$answer2 = day5_intop($input, 5);
return "Part1: ".$answer1.", Part2: ".$answer2;
?>

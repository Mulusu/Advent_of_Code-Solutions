<?php
$answer1 = "";
$answer2 = "";

function day7_intop(array $codes, int $phase, int $amp_input, int $i){
	$phase_set = false;
	if($i != 0){
		$phase_set = true; // Not the first time running this
	}
	$done = false;
	for(; !$done; ){
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
				if(!$phase_set){
					$codes[$codes[$i+1]] = (string)$phase;
					$phase_set = true;
				}else{
					$codes[$codes[$i+1]] = (string)$amp_input;
				}
				$i += 2;
				break;
			case 4:
				$i += 2;
				return [$codes,$num1,$i];
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
	return [$codes, -1, -1];
}

function day7_permutations(int $min, int $max){
	$options = range($min,$max);
	foreach($options as $a1){
		foreach($options as $a2){
			if($a1 == $a2){ continue; }
			foreach($options as $a3){
				if($a3 == $a1 || $a3 == $a2){ continue; }
				foreach($options as $a4){
					if($a4 == $a1 || $a4 == $a2 || $a4 == $a3){ continue; }
					foreach($options as $a5){
						if($a5 == $a1 || $a5 == $a2 || $a5 == $a3 || $a5 == $a4){ continue; }
						$permutations[] = [$a1,$a2,$a3,$a4,$a5];
					}
				}
			}
		}
	}
	return $permutations;
}

$code[] = $code[] = $code[] = $code[] = $code[] = [explode(",", trim($input)),explode(",", trim($input))];
$perms = [day7_permutations(0,4), day7_permutations(5,9)];

foreach(range(0,count($perms[0])-1) as $a){
	$output1 = 0;
	$output2 = 0;
	$toengine = 0;
	$pointers = [0,0,0,0,0];

	// Part1
	foreach(range(0,4) as $i){
		$output1 = day7_intop($code[$i][0], $perms[0][$a][$i], $output1, 0)[1];
	}

	// Part2
	$done = false;
	while(!$done){
		foreach(range(0,4) as $i){
			if($pointers[$i] != -1){
				$res = day7_intop($code[$i][0], $perms[1][$a][$i], $output2, $pointers[$i]);
				$pointers[$i] = $res[2];
				$code[$i][1] = $res[0];
				$output2 = $res[1];
				if($pointers[$i] != -1 and $i == 4){
					$toengine = $output2;
					if($toengine > $answer2){$answer2 = $toengine;}
				}
			} else{echo "PLING This shouldn't be run $i\n";}
		}
		$pcount = array_count_values($pointers);
		if(array_key_exists("-1", $pcount) and $pcount["-1"] == 5){
			$done = true;
		}
	}
	if($output1 > $answer1){
		$answer1 = $output1;
	}
	if($toengine > $answer2){
		$answer2 = $toengine;
	}

}

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

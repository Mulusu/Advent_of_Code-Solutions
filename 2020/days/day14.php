<?php
$answer1 = 0;
$answer2 = 0;

$lines = explode("\n", trim($input));
$mem = [];
$mem2 = [];
$mask = "0";

foreach($lines as $line){
	$parts = explode(" = ", $line);
	if($parts[0] == "mask"){
		$mask = $parts[1];
	}
	else{
		$address = str_replace("]", "", str_replace("mem[", "", $parts[0]));
		$address2 = [str_pad(decbin($address), 36, "0", STR_PAD_LEFT )];
		$num = str_pad(decbin($parts[1]), 36, "0", STR_PAD_LEFT );

		for($i = 0; $i < 36; $i++){
			// For part1
			if($mask[$i] != "X"){
				$num[$i] = $mask[$i];
			}

			if($mask[$i] == "1"){
				for($a = 0; $a < count($address2); $a++){
					$address2[$a][$i] = $mask[$i];
				}
			}

			if($mask[$i] == "X"){
				$newaddr2 = [];
				foreach($address2 as $a){
					$a1 = $a2 = $a;
					$a1[$i] = "0";
					$a2[$i] = "1";
					$newaddr2[] = $a1;
					$newaddr2[] = $a2;
				}
				$address2 = $newaddr2;
			}
		}
		$mem[$address] = bindec($num);
		foreach($address2 as $addr){
			$mem2[bindec($addr)] = $parts[1];
		}
	}
}

$answer1 = array_sum($mem);
$answer2 = array_sum($mem2);
return "Part1: ".$answer1.", Part2: ".$answer2;
?>

<?php
$answer1 = 0;
$answer2 = 0;

$lines = explode("\n", trim($input));

function day8_cpu(array $lines){
	$acc = 0;
	$done = [];
	$terminated = false;
	for($i = 0; !in_array($i, $done); ){
		if($i >= count($lines)){
			$terminated = true; // Ended as it should
			break;
		}
		$parts = explode(" ", $lines[$i]);
		$done[] = $i;
		switch($parts[0]){
			case "nop":
				$i++;
				break;
			case "acc":
				$acc = $acc + $parts[1];
				$i++;
				break;
			case "jmp":
				$i = $i + $parts[1];
				break;
		}
	}
	return [$acc,$terminated];
}
$answer1 = day8_cpu($lines)[0];

for($i = 0; $i < count($lines); $i++){
	$newlines = $lines;
	switch(substr($newlines[$i],0,3)){
		case "jmp":
			$newlines[$i] = str_replace("jmp","nop",$newlines[$i]);
			break;
		case "nop":
			$newlines[$i] = str_replace("nop","jmp",$newlines[$i]);
			break;
	}
	$ret = day8_cpu($newlines);
	if($ret[1]){ // Terminated correctly!
		$answer2 = $ret[0];
		break;
	}
}

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

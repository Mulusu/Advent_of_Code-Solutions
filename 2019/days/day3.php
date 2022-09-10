<?php
$answer1 = 0;
$answer2 = 0;

function day3_wire(string $wire){
	$inst = explode(",",$wire);
	$path = [];
	$x = 0;
	$y = 0;
	foreach($inst as $i){
		$num = substr($i,1);
		$dir = $i[0];
		for($num = substr($i,1); $num > 0; $num--){
			switch($dir){
				case "U":
					$y++;
					break;
				case "D":
					$y--;
					break;
				case "L":
					$x--;
					break;
				case "R":
					$x++;
					break;
			}
			$path[] = "$x,$y";
		}
	}
	return $path;
}

$wires = explode("\n",trim($input));
$wire1 = day3_wire($wires[0]);
$wire2 = day3_wire($wires[1]);

$intersections = array_intersect($wire1, $wire2);
foreach($intersections as $inter){
	$in = explode(",",$inter);
	$manhattan = abs($in[0]) + abs($in[1]);
	if($manhattan < $answer1 or $answer1 == 0){
		$answer1 = $manhattan;
	}
	$steps = array_search($inter, $wire1) + array_search($inter, $wire2) + 2; // +2 for origo
	if($steps < $answer2 or $answer2 == 0){
		$answer2 = $steps;
	}
}
return "Part1: ".$answer1.", Part2: ".$answer2;
?>

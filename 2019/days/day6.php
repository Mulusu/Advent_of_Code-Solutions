<?php
$answer1 = 0;
$answer2 = 0;

$orbits = explode("\n", trim($input));
$map = [];

foreach($orbits as $orb){
	$parts = explode(")",$orb);
	$map[$parts[1]] = $parts[0];
}
foreach($map as $m){
	$parent = $m;
	while($parent != "COM"){
		$answer1++;
		$parent = $map[$parent];
	}
	$answer1++; // For COM
}
$myparent = $map["YOU"];
$mysteps = 0;
$done = false;
while($myparent != "COM" and !$done){
	$santaparent = $map["SAN"];
	$santasteps = 0;
	while($santaparent != "COM" and !$done){
		if($myparent == $santaparent){
			$answer2 = $mysteps + $santasteps;
			$done = true;
		}
		$santaparent = $map[$santaparent];
		$santasteps++;
	}
	$myparent = $map[$myparent];
	$mysteps++;
}

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

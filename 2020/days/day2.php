<?php

$answer1 = 0;
$answer2 = 0;
$passwords = explode("\n", trim($input));

foreach($passwords as $line){
	$parts = explode(":", trim($line));
	$pw = trim($parts[1]);
	$limits = explode("-", explode(" ", $parts[0])[0]);
	$letter = trim(explode(" ",$parts[0])[1]);

	$count = substr_count($pw, $letter);

	if($count >= $limits[0] and $count <= $limits[1]){
		$answer1 = $answer1 + 1;
	}
	if($pw[(int)$limits[0]-1] == $letter xor $pw[(int)$limits[1]-1] == $letter){
		$answer2 = $answer2 + 1;
	}
}

	return "Part1: ".$answer1.", Part2: ".$answer2;

?>

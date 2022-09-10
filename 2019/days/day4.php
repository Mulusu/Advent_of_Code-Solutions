<?php
$answer1 = 0;
$answer2 = 0;
$range = explode("-",trim($input));

for($i = $range[0]; $i <= $range[1]; $i++){
	$parts = str_split($i);
	$sorted = $parts;
	sort($sorted);
	if($sorted === $parts and count($parts) !== count(array_unique($parts))){
		$answer1++;
		if(in_array(2,array_count_values($parts))){
			$answer2++;
		}
	}
}

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

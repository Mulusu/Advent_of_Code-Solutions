<?php
$answer1 = 0;
$answer2 = 0;

$num = explode("\n", trim($input));
for($i = 25; $i < count($num); $i++){
	$matched = false;
	for($x = $i - 25; $x < $i and !$matched; $x++){
		for($y = $i - 25; $y < $i and !$matched; $y++){
			if($x == $y) { continue; } // Can't be same

			if($num[$x] + $num[$y] == $num[$i]){
				$matched = true;
				continue; //Valid, do nothing
			}
		}
	}
	if(!$matched){
		$answer1 = $num[$i];
		break;
	}
}

$done = false;
for($i = 0; $i < count($num) and !$done; $i++){
	$sum = 0;
	$summed = [];
	for($x = $i; $x < count($num) and !$done; $x++){
		$sum += $num[$x];
		$summed[] = $num[$x];
		if($sum > $answer1){break;} // Too large, not found
		if($sum == $answer1){ // FOUND
			$done = true;
			$answer2 = min($summed) + max($summed);
		}
	}
}
return "Part1: ".$answer1.", Part2: ".$answer2;
?>

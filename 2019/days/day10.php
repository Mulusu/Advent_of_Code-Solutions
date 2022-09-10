<?php
$answer1 = 0;
$answer2 = 0;
$map = explode("\n", trim($input));

function day10_detect_asteroids(array $map, array $c){
	$detected = 0;
	$angles = [];
	$asteroids = [];
	// Expand search radius step by step
	for($offset = 1; true ;$offset++){
		$coords = [];
		// Get coordinates to search
		for($y = $c[0] - $offset; $y <= $c[0] + $offset; $y++){
			for($x = $c[1] - $offset; $x <= $c[1] + $offset; $x++){
				// At least one of the coords need to be at max offset (the others have been checked already)
				if($x != $c[1] - $offset and $x != $c[1] + $offset and $y != $c[0] - $offset and $y != $c[0] + $offset){
					continue;
				}
				// if coordinate to check within map, add to list
				if($x >= 0 and $x < strlen($map[0]) and $y >= 0 and $y < count($map) and $map[$y][$x] == "#"){
					$coords[] = [$y,$x];
				}
			}
		}

		// If no more valid coordinates to search
		if(count($coords) == 0){
			break;
		}

		foreach($coords as $co){
			$angle = 180 - rad2deg(atan2($co[1]-$c[1], $co[0]-$c[0]));
			$angle = round(($angle < 0) ? $angle + 360 : $angle,1);
			if(!in_array($angle, $angles)){
				$angles[] = $angle;
				$asteroids[$angle*10] = [$co[0],$co[1]];
				$detected++;
			}
		}
	}
	return [$detected, $asteroids];
}

$monitor_coord = [];
$detected = [];
for($y = 0; $y < count($map); $y++){
	for($x = 0; $x < strlen($map[$y]); $x++){
		if($map[$y][$x] == "#"){ // Is asteroid
			$asteroids = day10_detect_asteroids($map,[$y,$x]);
			if($asteroids[0] > $answer1){
				$answer1 = $asteroids[0];
				$monitor_coord = [$y,$x];
				$detected = $asteroids[1];
			}
		}
	}
}

ksort($detected);
$d = array_values($detected)[199];
$answer2 = $d[1] * 100 + $d[0];

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

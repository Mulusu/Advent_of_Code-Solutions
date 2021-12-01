<?php
$answer1 = 0;
$answer2 = 0;

$parts = explode("\n", trim($input));
$first_possible = $parts[0];
$busses = explode(",", $parts[1]);

$depart = 9999999999; // Just a big number so it is overwritten at first opportunity
foreach($busses as $bus){
	if($bus == "x") {continue;}
	for($d = 0; $d < $first_possible + $bus; $d += $bus){
		if($d >= $first_possible){ // Check if best option
			if($d < $depart){
				$depart = $d;
				$answer1 = $bus;
			}
			break;
		}
	}
}
$answer1 = $answer1 * ($depart - $first_possible);

// PART2

$aligned = $busses[0]; // First bus is obviously aligned to its own schedule
$t = 0;
for($b = 1 ; $b < count($busses); $b++){
	if($busses[$b] == "x"){ continue; }
	while( ($t+$b) % $busses[$b] > 0){ // Shift t until bus b is aligned correctly the schedule
		$t += $aligned;
	}
	$aligned *= $busses[$b]; // From now on shift by the number where all aligned busses are on correct schedule
}
$answer2 = $t;

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

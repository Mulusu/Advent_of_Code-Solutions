<?php
$answer1 = 0;
$answer2 = 0;

$adapters = explode("\n", trim($input));
sort($adapters);
$internal = max($adapters)+3;
$diffs = [0,0,0];
$prev = 0;
// Adapter can take 1-3 jolts LOWER
// In order to use all, they need to be used in order (so the previous is always lower)
foreach($adapters as $a){
	$diff = $a - $prev;
	if($diff < 1 or $diff > 3){
		echo "ERROR: adapter ($diff) not valid!\n";
		break;
	}
	$diffs[$diff-1] += 1;
	$prev = $a;
}
$diffs[2]++; // The difference to internal.
$answer1 = $diffs[0] * $diffs[2];

// Calculate how many possible paths there is to reach a given adapter from the starting zero
// Each adapter can be reached by the sum of the total paths to the adapters leading to it.

// Ie. if adapter x can be reached by 3 different ways,
// and adapter y can be reached by 2 different ways
// and adapter z can be reached by either through adapter x or y,
// then the adapter z can be reached by 3 (x) + 2 (y) different ways total.

$counts = [1]; // First can only be reached from zero
for($i = 1; $i < count($adapters); $i++){ // Iterate through all (except first) adapter
	$count = 0;
	if($adapters[$i] < 4){$count++;} // Can be reached from 0, ergo +1 to paths
	for($a = $i-3; $a < $i; $a++){
		if($a < 0){continue;}	// Negative index
		$diff = $adapters[$i] - $adapters[$a];
		if($diff > 3){continue;} // Difference too high
		$count += $counts[$a];	// This adapter can be reached via (at least) as many paths as the one leading to this (plus any way to reach any other adapter that can lead to this)
	}
	$counts[$i] = $count;
}
$answer2 = $counts[count($counts)-1];

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

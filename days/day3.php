<?php
$answer1 = 1;
$answer2 = 1;

$hill = explode("\n", trim($input));
$slopes = [[1,1],[3,1],[5,1],[7,1],[1,2]]; // [right, down]

foreach($slopes as $slope){
	$trees = 0;
	$y = 0;
	$x = 0;
	while($y < count($hill)){
		if($hill[$y][$x] == "#"){
			$trees += 1;
		}
		$y += $slope[1];
		$x += $slope[0];
		if($y >= count($hill)){break;}
		if($x >= strlen($hill[$y])){
			$x = $x - strlen($hill[$y]);
		}
	}
	if($slope == [3,1]){
		$answer1 = $trees;
	}
	$answer2 = $answer2 * $trees;
}
return "Part1: " . $answer1 . ", Part2: " . $answer2;
?>

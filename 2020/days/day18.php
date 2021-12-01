<?php
$answer1 = 0;
$answer2 = 0;

$lines = explode("\n",trim($input));
//$lines = ["((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2"]; // Debug input

// Find and return the location of first parentheses in equation
function day18_find_parentheses_pair(string $eq){
	$open = strpos($eq,"(");
	if($open !== false){
		for($i = $open + 1; ; ){
			$next_close = strpos($eq, ")", $i);
			$next_open = strpos($eq, "(", $i);

			// No more open parentheses or they are later than closing one for this
			if($next_open === false or $next_open > $next_close){
				$found = true;
				return [$open,$next_close];
			}
			// These parentheses contain other set of parentheses, find the closing one for this
			else{
				$i = $next_close + 1;
			}
		}
	}
	return false;
}

// Solve one set of parentheses at a time, recursive
function day18_solve_math(string $eq, int $part){
	$par = day18_find_parentheses_pair($eq);
	while($par !== false){
		$subeq = substr($eq, $par[0]+1, $par[1]-$par[0]-1);
		$res = day18_solve_math($subeq, $part);

		$cut1 = $par[0] != 0 ? substr($eq,0,$par[0]) : "";
		$cut2 = $par[1] != strlen($eq)-1 ? substr($eq,$par[1]+1) : "";

		$eq = $cut1 . $res . $cut2;
		$par = day18_find_parentheses_pair($eq); // repeat until all parentheses have been replaced
	}

	// No more parentheses, just solve the equation
	$nums = preg_split("/[+*]/",$eq);
	$ops = [];
	preg_match_all("/[+*]/", $eq, $ops);
	$ops = $ops[0];
	$answer = 0;

	// PART1 SOLVER
	if($part == 1){
		$answer = $nums[0];
		for($i = 0; $i < count($ops); $i++){
			if($ops[$i] == "+"){
				$answer += $nums[$i+1];
			}
			else{
				$answer *= $nums[$i+1];
			}
		}
	}

	// PART2 SOLVER
	if($part == 2){
		// Process first all plusses
		for($i = 0; $i < count($ops); $i++){
			if($ops[$i] != "+"){ continue; }
			$sum = $nums[$i] + $nums[$i+1];
			$nums[$i] = $sum;
			array_splice($nums,$i+1,1);
			array_splice($ops,$i,1);
			$i = -1;
		}
		// Now then process only the multiplications
		for($i = 0; $i < count($ops); $i++){
			$mult = $nums[$i] * $nums[$i+1];
			$nums[$i] = $mult;
			array_splice($nums,$i+1,1);
			array_splice($ops,$i,1);
			$i = -1;
		}
		$answer = $nums[0];
	}

	return $answer;
}

foreach($lines as $line){
	$answer1 += day18_solve_math(str_replace(" ","",$line),1);
	$answer2 += day18_solve_math(str_replace(" ","",$line),2);
}

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

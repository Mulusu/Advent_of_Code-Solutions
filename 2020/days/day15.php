<?php
$answer1 = 0;
$answer2 = 0;

$starting_nums = explode(",", trim($input));
//$starting_nums = [0,3,6]; // DEBUG

$turn = 1;
$said = [];
$last_said = -99;
foreach($starting_nums as $num){
	if($last_said > -1){
		$said[$last_said] = $turn - 1;
	}
	$last_said = $num;
	$turn++;
}

$num = 0;
for(; $turn <= 30000000; $turn++){
	if(array_key_exists($last_said, $said)){
		$num = $turn - 1 - $said[$last_said];
	}
	else{
		$num = 0;
	}
	$said[$last_said] = $turn - 1;
	$last_said = $num;
	if($turn == 2020){
		$answer1 = $last_said;
	}
}
$answer2 = $last_said;

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

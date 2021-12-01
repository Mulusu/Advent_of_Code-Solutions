<?php
$answer1 = 0;
$answer2 = 0;
$min = 9999;
$taken = [];

$lines = explode("\n", trim($input));
foreach($lines as $line){
	$line = str_replace("L","0",str_replace("R","1",str_replace("B","1",str_replace("F","0",$line))));
	$row = bindec(substr($line,0,-3));
	$col = bindec(substr($line,-3));
	$id = $row * 8 + $col;
	if($id > $answer1){
		$answer1 = $id;
	}
	if($id < $min){
		$min = $id;
	}
	$taken[] = $id;
}
for($i = $min+1; $i < $answer1; $i++){
	if(!in_array($i,$taken)){
		$answer2 = $i;
		break;
	}
}
return "Part1: ".$answer1.", Part2: ".$answer2;
?>

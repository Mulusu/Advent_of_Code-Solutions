<?php
$answer1 = 0;
$answer2 = 0;

$groups = explode("\n\n",trim($input));
foreach($groups as $group){
	$yes = [];
	$counts = [];
	$persons = explode("\n",$group);
	foreach($persons as $p){
		for($i = 0; $i < strlen($p); $i++){
			if(!in_array($p[$i],$yes)){
				$yes[] = $p[$i];
				$counts[$p[$i]] = 1;
			}
			else{
				$counts[$p[$i]] += 1;
			}
		}
	}
	$answer1 += count($yes);
	foreach($yes as $c){
		if($counts[$c] == count($persons)){
			$answer2 += 1;
		}
	}
}
return "Part1: ".$answer1.", Part2: ".$answer2;
?>

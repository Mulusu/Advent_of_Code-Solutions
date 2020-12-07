<?php
$answer1 = 0;
$answer2 = 0;

$lines = explode(".\n",trim($input));
$rules = [];
$rulesbc = [];

foreach($lines as $rule){
	if(strlen($rule) == 0){continue;}
	$parts = explode(" bags contain ", trim($rule));
	$parent = $parts[0];
	$childs = explode(", ",$parts[1]);
	foreach($childs as $child){
		$words = explode(" ",trim($child));
		if($words[0] == "no"){continue;}
		$amount = $words[0];
		$color = $words[1] . " " . $words[2];
		if(array_key_exists($color ,$rules)){
			array_push($rules[$color], array($parent,$amount));
		}else{
			$rules[$color] = array(array($parent, $amount));
		}
		if(array_key_exists($parent ,$rulesbc)){
			array_push($rulesbc[$parent], array($color,$amount));
		}else{
			$rulesbc[$parent] = array(array($color, $amount));
		}
	}
}

$possible = [];
$parents = $rules["shiny gold"]; // [[parent,amount],[parent,amount],...]
while(count($parents)){
	$newparents = [];
	foreach($parents as $parent){	//[parent, amount]
		$possible[] = $parent[0];
		if(array_key_exists($parent[0],$rules)){
			foreach($rules[$parent[0]] as $neorule){
				$newparents[] = $neorule;
			}
		}
	}
	$parents = $newparents;
}
$answer1 = count(array_unique($possible));

function day7_get_number(string $color, array $rules){
	if(!array_key_exists($color, $rules)){ // End of the line
		return 1; // Just one bag, itself.
	}else{
		$number = 1;
		foreach($rules[$color] as $sub){
			$number += $sub[1] * day7_get_number($sub[0], $rules);
		}
	}
	return $number;
}
$answer2 = day7_get_number("shiny gold", $rulesbc) -1; // -1 since gold bag does not contain itself



return "Part1: ".$answer1.", Part2: ".$answer2;
?>

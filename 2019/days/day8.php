<?php
$answer1 = 0;
$answer2 = 0;

$layersize = 25*6;
$layers = explode("#", chunk_split($input,$layersize, "#"));
$minzeros = 25*6;
foreach($layers as $layer){
	if(strlen($layer) != 25*6){continue;}
	$zeros = substr_count($layer,"0");
	if($zeros < $minzeros){
		$minzeros = $zeros;
		$answer1 =  substr_count($layer, "1") * substr_count($layer, "2");
	}
}
$final_layer = $layers[0];
for($i=1; $i < count($layers); $i++){
	if(strlen($layers[$i]) == 0){continue;}
	for($p=0; $p < strlen($layers[$i]); $p++){
		if($final_layer[$p] == 2){
			$final_layer[$p] = $layers[$i][$p];
		}
	}
}

$answer2 = str_replace("0", " ", str_replace("1", "#",chunk_split($final_layer,25,"\n")));
return "Part1: ".$answer1.", Part2:\n".$answer2;
?>

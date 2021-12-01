<?php
$answer1 = 0;
$answer2 = 0;

$req = ["byr","iyr","eyr","hgt","hcl","ecl","pid"];
$passports = explode("\n\n", trim($input));

foreach($passports as $pp){
	$fields = [];
	foreach(explode(" ",str_replace("\n", " ", $pp)) as $f){
		$fields[explode(":", $f)[0]] = explode(":", $f)[1];
	}
	if(count(array_diff($req, array_keys($fields))) == 0){
		$answer1 += 1;
		if((int)$fields["byr"] < 1920 or (int)$fields["byr"] > 2002){continue;}
		if((int)$fields["iyr"] < 2010 or (int)$fields["iyr"] > 2020){continue;}
		if((int)$fields["eyr"] < 2020 or (int)$fields["eyr"] > 2030){continue;}
		if(substr($fields["hgt"],-2) == "in" and ((int)substr($fields["hgt"],0,-2) < 59 or (int)substr($fields["hgt"],0,-1) > 76) ){continue;}
		if(substr($fields["hgt"],-2) == "cm" and ((int)substr($fields["hgt"],0,-2) < 150 or (int)substr($fields["hgt"],0,-1) > 193) ){continue;}
		if(substr($fields["hgt"],-2) != "in" and substr($fields["hgt"],-2) != "cm"){continue;}
		if(strlen($fields["hcl"]) != 7 or $fields["hcl"][0] != "#" or !ctype_xdigit(substr($fields["hcl"], 1))){continue;}
		if(!in_array($fields["ecl"], ["amb","blu","brn","gry","grn","hzl","oth"])){continue;}
		if(strlen($fields["pid"]) != 9 or !is_numeric($fields["pid"])){continue;}
		$answer2 += 1;
	}
}
return "Part1: ".$answer1.", Part2: ".$answer2;
?>

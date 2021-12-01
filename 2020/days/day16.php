<?php
$answer1 = 0;
$answer2 = 1;

// Debug input
//$input = "class: 0-1 or 4-19\nrow: 0-5 or 8-19\nseat: 0-13 or 16-19\n\nyour ticket:\n11,12,13\n\nnearby tickets:\n3,9,18\n15,1,5\n5,14,9";


$parts = explode("\n\n", trim($input));
$rules = explode("\n", trim($parts[0]));
$own_ticket = explode(",", explode("\n", $parts[1])[1]); // Drop "your ticket" title line
$tickets = array_slice(explode("\n", $parts[2]),1); // Drop "nearby tickets" title line
$r_to_f = array_fill(0, count($rules), range(0,count($rules)-1));

foreach($tickets as $t){
	$valid_ticket = true; 	// Presume valid, invalidate if found a field without any valid rule
	$valid_fields = [];	// List of which rules are fulfilled by what fields
	$fields = explode(",",$t);
	for($f = 0; $f < count($fields); $f++){	// Iterate all fields
		$valid = false;	// Flag if there is at least one valid rule for this field

		for($r=0; $r < count($rules); $r++){	// Iterate all rules
			$pr = explode(" or ",explode(": ", $rules[$r])[1]);
			$range = [ explode("-", $pr[0]) , explode("-", $pr[1]) ];

			if(($fields[$f] < $range[0][0] or $fields[$f] > $range[0][1]) and
			   ($fields[$f] < $range[1][0] or $fields[$f] > $range[1][1])){
				continue; // Invalid field according to rule r, check next rule
			}

			$valid = true;
			$valid_fields[$r][] = $f; // Field f is valid according to rule r
		}

		if(!$valid){		// No valid rule found for this field --> invalid ticket!
			$answer1 += $fields[$f];
			$valid_ticket = false;
		}
	}

	// If the ticket is valid, check which fields could not be certain rules,
	// and remove them from r_to_f, as that mapping can not be correct
	if($valid_ticket){
		for($r = 0; $r < count($rules); $r++){
			$r_to_f[$r] = array_intersect($r_to_f[$r], $valid_fields[$r]);
		}
	}
}

// Check if any field is the only choice for some rule, meaning it must be that and can be removed from the rest
$singular = array_fill(0,count($rules),0);
while(array_sum($singular) < count($rules)){
	$changed = false;
	for($r = 0; $r < count($rules); $r++){
		if($singular[$r] != 1 and count($r_to_f[$r]) == 1){
			$changed = true;
			$r_to_f[$r] = array_pop($r_to_f[$r]);
			$singular[$r] = 1;
			for($i = 0; $i < count($rules); $i++){
				if($i == $r){continue;}
				if($singular[$i]){continue;}
				$r_to_f[$i] = array_diff($r_to_f[$i], [$r_to_f[$r]]);
			}
		}
	}
	if(!$changed){
		echo "WARN: All r_to_f values are not single values, double check the code!\n";
		break;
	}
}


for($i = 0; $i < 6; $i++){
	$val = $r_to_f[$i];
	$answer2 *= $own_ticket[$val];
}

return "Part1: ".$answer1.", Part2: ".$answer2;
?>

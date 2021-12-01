<?php
$answer1 = 0;
$answer2 = 0;

// debug input
//$input  = ".#.\n..#\n###";

$initial = explode("\n",trim($input)); // Let's put it at z = 0
$map = [[[]]];
$map2 = [[[[]]]];
// input the initial map to our map
for($y=0; $y < count($initial); $y++){
	for($x=0; $x < strlen($initial[$y]); $x++){
		$map[$x][$y][0] = ($initial[$y][$x] == "#" ? 1 : 0);
		$map2[$x][$y][0][0] = ($initial[$y][$x] == "#" ? 1 : 0);
	}
}

$limits = [[0, count($map)-1],[0,count($initial)-1],[0,0],[0,0]]; // The extreme ends of each index available

// For six boot cycles
for($i = 0; $i < 6; $i++){
	$newmap = $map;
	$newmap2 = $map2;
	$newlimits = $limits;

	// Iterate througn the known limits, expanded by one in each direction
	// Since activation requirement considers only neighbours, expanding by one is enough
	for($x = $limits[0][0]-1; $x <= $limits[0][1] + 1; $x++){
		for($y = $limits[1][0]-1; $y <= $limits[1][1] + 1; $y++){
			for($z = $limits[2][0]-1; $z <= $limits[2][1] + 1; $z++){

				// ############ PART 2 ############## extra dimension
				// TODO: make more elegant than copy paste?
				for($w = $limits[3][0]-1; $w <= $limits[3][1] + 1; $w++){
					$active_around2 = 0;
					$state2 = $map2[$x][$y][$z][$w] ?? 0;

					// Check the surrounding cells
					for($xx = $x-1; $xx <= $x+1; $xx++){
						for($yy = $y-1; $yy <= $y+1; $yy++){
							for($zz = $z-1; $zz <= $z+1; $zz++){
								for($ww = $w-1; $ww <= $w+1; $ww++){
									if($xx == $x and $yy == $y and $zz == $z and $ww == $w){ // this cell, not a neighbour
										continue;
									}
									$active_around2 += $map2[$xx][$yy][$zz][$ww] ?? 0;	// If index does not exist, add 0
								}
							}
						}
					}
					// Active --> inactive
					if($state2 == 1 and $active_around2 != 2 and $active_around2 != 3){
						$newmap2[$x][$y][$z][$w] = 0;
					}

					// Inactive --> active
					if($state2 == 0 and $active_around2 == 3){
						$newmap2[$x][$y][$z][$w] = 1;
					}

					// Expand the known limits if needed
					$newlimits[3] = [min($w, $newlimits[3][0]), max($w, $newlimits[3][1])];
				}


				// ############# PART 1 ################
				$active_around = 0;
				$state = $map[$x][$y][$z] ?? 0;

				// Check the surrounding cells
				for($xx = $x-1; $xx <= $x+1; $xx++){
					for($yy = $y-1; $yy <= $y+1; $yy++){
						for($zz = $z-1; $zz <= $z+1; $zz++){
							if($xx == $x and $yy == $y and $zz == $z){ // this cell, not a neighbour
								continue;
							}
							$active_around += $map[$xx][$yy][$zz] ?? 0;	// If index does not exist, add 0
						}
					}
				}
				// Active --> inactive
				if($state == 1 and $active_around != 2 and $active_around != 3){
					$newmap[$x][$y][$z] = 0;
				}

				// Inactive --> active
				if($state == 0 and $active_around == 3){
					$newmap[$x][$y][$z] = 1;

				}

				// Expand the known limits if needed
				$newlimits[2] = [min($z, $newlimits[2][0]), max($z, $newlimits[2][1])];
			}
			$newlimits[1] = [min($y, $newlimits[1][0]), max($y, $newlimits[1][1])];
		}
		$newlimits[0] = [min($x, $newlimits[0][0]), max($x, $newlimits[0][1])];
	}
	$map = $newmap;
	$map2 = $newmap2;
	$limits = $newlimits;
}

for($x = $limits[0][0]; $x <= $limits[0][1]; $x++){
	for($y = $limits[1][0]; $y <= $limits[1][1]; $y++){
		for($z = $limits[2][0]; $z <= $limits[2][1]; $z++){
			$answer1 += $map[$x][$y][$z] ?? 0;
			for($w = $limits[3][0]; $w <= $limits[3][1]; $w++){
				$answer2 += $map2[$x][$y][$z][$w] ?? 0;
			}
		}
	}
}
return "Part1: ".$answer1.", Part2: ".$answer2;
?>

<?php
$answer1 = 0;
$answer2 = 0;

$map = $map2 = explode("\n",trim($input));
$newmap = $map;
$newmap2 = $map2;
while(true){
	$changed = false;
        for($y = 0; $y < count($map); $y++){
                for($x = 0; $x < strlen($map[$y]); $x++){
                        if($map[$y][$x] == "."){
                                continue; // Floor doesn't change
                        }

			// Check taken for part1
                        $taken = 0;
                        for($yo = $y-1; $yo < $y+2; $yo++){
                                for($xo = $x-1; $xo < $x+2; $xo++){
                                        if($yo < 0 or $yo >= count($map) or $xo < 0 or $xo >= strlen($map[$yo])){
                                                continue;       // Out of bounds
                                        }
                                        if($yo == $y and $xo == $x){continue;} // same
                                        if($map[$yo][$xo] == "#"){
                                                $taken++;
                                        }
                                }
                        }

			// Check taken for part2
			$taken2 = 0;
			$checked = [0,0,0,0,0,0,0,0];
			for($offset = 1; array_sum($checked) < 8 ; $offset++){
				$tc = [[$y+$offset,$x],[$y+$offset,$x+$offset],[$y,$x+$offset],[$y-$offset,$x+$offset],
				       [$y-$offset,$x],[$y-$offset,$x-$offset],[$y,$x-$offset],[$y+$offset,$x-$offset]];
				for($i=0; $i < 8; $i++ ){
					if($checked[$i] == 1) {continue;}
					$xo = $tc[$i][1];
					$yo = $tc[$i][0];
					if($xo < 0 or $yo < 0 or $xo >= strlen($map2[$y]) or $yo >= count($map2)){
						$checked[$i] = 1;
						continue;
					}
					if($map2[$yo][$xo] == "."){continue;}
					$checked[$i] = 1;
					if($map2[$yo][$xo] == "#"){
						$taken2++;
					}
				}
			}

                        // Free seat, part1
                        if($map[$y][$x] == "L" and $taken == 0){
                                $newmap[$y][$x] = "#";
				$changed = true;
                        }

                        // Taken seat, part1
                        if($map[$y][$x] == "#" and $taken > 3){
                                $newmap[$y][$x] = "L";
				$changed = true;
                        }

			// Free seat, part2
			if($map2[$y][$x] == "L" and $taken2 == 0){
				$newmap2[$y][$x] = "#";
				$changed = true;
			}

			// Taken seat, part2
			if($map2[$y][$x] == "#" and $taken2 > 4){
				$newmap2[$y][$x] = "L";
				$changed = true;
			}
                }
        }
        // If nothing has changed
        if(!$changed){
                break;
        }
        else{
                $map = $newmap;
		$map2 = $newmap2;
        }
}
foreach($map as $row){
        $answer1 += substr_count($row, "#");
}
foreach($map2 as $row){
	$answer2 += substr_count($row, "#");
}
return "Part1: ".$answer1.", Part2: ".$answer2;
?>


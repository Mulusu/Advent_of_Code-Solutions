<?php
$answer1 = 0;
$answer2 = 0;

$lines = explode("\n", trim($input));
$dir = 90;

$pos1 = [0,0];
$pos2 = [0,0];
$wp = [10,1];

foreach($lines as $line){
	$inst = $line[0];
	$num = (int)substr($line,1);
	switch($inst){
		case "N":
			$pos1[1] += $num;
			$wp[1] += $num;
			break;
		case "S":
			$pos1[1] -= $num;
			$wp[1] -= $num;
			break;
		case "E":
			$pos1[0] += $num;
			$wp[0] += $num;
			break;
		case "W":
			$pos1[0] -= $num;
			$wp[0] -= $num;
			break;
		case "L":
			$dir -= $num;
			if($dir < 0){
				$dir += 360;
			}
			$oldwp = $wp;
			switch($num){
                                case 90:
                                        $wp[0] = -$oldwp[1];
                                        $wp[1] = $oldwp[0];
                                        break;
                                case 180:
                                        $wp[0] = -$oldwp[0];
                                        $wp[1] = -$oldwp[1];
                                        break;
                                case 270:
                                        $wp[0] = $oldwp[1];
                                        $wp[1] = -$oldwp[0];
                                        break;

                        }
			break;
		case "R":
			$dir += $num;
			if($dir >= 360){
				$dir -= 360;
			}
			$oldwp = $wp;
			switch($num){
				case 90:
					$wp[0] = $oldwp[1];
					$wp[1] = -$oldwp[0];
					break;
				case 180:
					$wp[0] = -$oldwp[0];
					$wp[1] = -$oldwp[1];
					break;
				case 270:
					$wp[0] = -$oldwp[1];
					$wp[1] = $oldwp[0];
					break;

			}
			break;
		case "F":
			switch($dir){
				case 0:
					$pos1[1] += $num;
					break;
				case 90:
					$pos1[0] += $num;
					break;
				case 180:
					$pos1[1] -= $num;
					break;
				case 270:
					$pos1[0] -= $num;
					break;
				default:
					echo "ERROR: unexpected dir: $dir\n";
					break;
			}
			$pos2[0] += $num * $wp[0];
			$pos2[1] += $num * $wp[1];
			break;
	}

}
$answer1 = abs($pos1[0]) + abs($pos1[1]);
$answer2 = abs($pos2[0]) + abs($pos2[1]);
return "Part1: ".$answer1.", Part2: ".$answer2;
?>

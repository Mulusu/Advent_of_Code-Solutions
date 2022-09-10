<?php
$answer1 = "";
$answer2 = "";

function day11_intcode(array $codes, int $op, int $i){
	$out = [];
        $relative = 0;
        $done = false;
        for( ; !$done; ){
                if($i > count($codes)){
                        echo 'Out of bounds! '.$i.' '.$num1.' '.$num2."\n";
                        return [0,0,$codes,-1];
                }
                $num1 = 0;
                $num2 = 0;
                $num3 = 0;
                $code = ((strlen($codes[$i]) >= 3) ? substr($codes[$i],-2) : $codes[$i]);
                if($code != 99){
                        if(strlen($codes[$i]) >= 3 and $codes[$i][-3] == "1"){
                                $num1 = $codes[$i+1];
                        }
                        else if(strlen($codes[$i]) >= 3 and $codes[$i][-3] == "2" and $code != 3){
                                $num1 = $codes[$relative + $codes[$i+1]];
                        }
                        else if(strlen($codes[$i]) >= 3 and $codes[$i][-3] == "2" and $code == 3){
                                $num1 = $relative + $codes[$i+1];
                        }
                        else{
                                $num1 = $codes[$codes[$i+1]];
                        }
                }
                if($code != 3 and $code != 4 and $code != 99){
                        if(strlen($codes[$i]) >= 4 and $codes[$i][-4] == "1"){
                                $num2 = $codes[$i+2];
                        }
                        else if(strlen($codes[$i]) >= 4 and $codes[$i][-4] == "2"){
                                $num2 = $codes[$relative + $codes[$i+2]];
                        }
                        else{
                                $num2 = $codes[$codes[$i+2]];
                        }
                }
                if($code != 3 and $code != 4 and $code != 99){
                        if(strlen($codes[$i]) >= 5 and $codes[$i][-5] == "2"){
                                $num3 = $relative + $codes[$i+3];
                        }
                        else{
                                $num3 = $codes[$i+3];
                        }
                }
                switch ($code){
                        case 1:
                                $codes[$num3] = (string)($num1 + $num2);
                                $i += 4;
                                break;
                        case 2:
                                $codes[$num3] = (string)($num1 * $num2);
                                $i += 4;
                                break;
                        case 3:
                                $codes[$num1] = (string)$op;
                                $i += 2;
                                break;
                        case 4:
				$out[] = $num1;
                                $i += 2;
				if(count($out) == 2){
					return [$out[0],$out[1], $codes, $i];
				}
                                break;
                        case 5:
                                if($num1 != 0){
                                        $i = intval($num2);
                                } else{
                                        $i += 3;
                                }
                                break;
                        case 6:
                                if($num1 == 0){
                                        $i = intval($num2);
                                } else{
                                        $i += 3;
                                }
                                break;
                        case 7:
                                $codes[$num3] = (($num1 < $num2) ? 1 : 0);
                                $i += 4;
                                break;
                        case 8:
                                $codes[$num3] = (($num1 == $num2) ? 1 : 0);
                                $i += 4;
                                break;
                        case 9:
                                $relative += $num1;
                                $i += 2;
                                break;
                        case 99:
                                $done = true;
                                break;
                        default:
                                echo "BORKEN at $i: ".$code." ".$num1." ".$num2;
                                return [0,0, $codes, -1];
                }
        }
        return [0,0,$codes,-1];
}

$codes = explode(",", trim($input));
$fill = array_fill(count($codes), 10*count($codes), "0");
$codes += $fill;

$map = [];
$x = 0;
$y = 0;
$dir = 0;
$i = 0;
while(true){
	if(!array_key_exists($x.",".$y,$map)){
		$res = day11_intcode($codes,0,$i); // Not in map, ergo black
	}
	else{
		$res = day11_intcode($codes,$map[$x.",".$y],$i);
	}
	$col = $res[0];
	$turn = $res[1];
	$codes = $res[2];
	$i = $res[3];
	if($i == -1){break;}

	$map[$x.",".$y] = $col;
	$dir += (($turn == 0) ? -1 : 1);
	$dir = (($dir > 3) ? $dir - 4 : $dir);
	$dir = (($dir < 0) ? $dir + 4 : $dir);
	if($dir == 1 or $dir == 3){
		$x += (($dir == 1) ? 1 : -1);
	}
	else{
		$y += (($dir == 0) ? 1 : -1);
	}
}

$answer1 = count($map);
return "Part1: ".$answer1.", Part2: ".$answer2;
?>

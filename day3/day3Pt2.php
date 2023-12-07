<?php
error_reporting(E_ALL);
$file = file("input");

$dir = [
  [-1,-1], [0,-1], [1,-1],
  [-1, 0],         [1, 0],
  [-1, 1], [0, 1], [1, 1]
];

$sum = 0;
$gearRatio = array();

function getAdjacent(int $i, int $j, array $coords, array $file): ?string {
  [$x, $y] = $coords;
  if($i+$x < 0 || $i+$x >= count($file)) return null;
  if($j+$y < 0 || $j+$y >= strlen($file[$i+$x])) return null;
  return $file[$i + $x][$j + $y];
}

function getFullPartNumber(int $x, int $y, string $partNumber): string {
  global $file;
  $defNumber = $partNumber;

  $defY = $y;

  while(strlen($file[$x]) > $y+1 && is_numeric($file[$x][$y+1])) {
    $partNumber = $partNumber . $file[$x][$y+1];
    $y++;
  }
  while(($defY-1) >= 0 && is_numeric($file[$x][$defY-1])) {
    $partNumber = $file[$x][$defY-1] . $partNumber;
    $defY--;
  }


  return $partNumber;
}

for($i = 0; $i < count($file); $i++) {
  for($j = 0; $j < strlen($file[$i]); $j++) {
    if($file[$i][$j] == "*") {
      $prevFoundedIn = [-1, -1];
      $partNumbers = 0;
      $number1;
      $number2;

      for($k = 0; $k < count($dir); $k++) {
        $adj = getAdjacent($i, $j, $dir[$k], $file);
        if(is_numeric($adj)) {
          if($prevFoundedIn[0] != -1) {
            [$x1, $y1] = $dir[$prevFoundedIn[0]];
            [$x2, $y2] = $dir[$k];
            if($x1 == $x2 && abs($y1 - $y2) == 1) {
              $prevFoundedIn[0] = $k;
              continue;
            }
          }
          if($prevFoundedIn[1] != -1) {
            [$x1, $y1] = $dir[$prevFoundedIn[1]];
            [$x2, $y2] = $dir[$k];
            if($x1 == $x2 && abs($y1 - $y2) == 1) {
              $prevFoundedIn[1] = $k;
              continue;
            }
          }
          $prevFoundedIn[$partNumbers] = $k;
          $partNumbers++;
          $x = $i + $dir[$k][0];
          $y = $j + $dir[$k][1];

          $tempN = getFullPartNumber($x, $y, $adj);
          if($tempN == "531") {
            echo "una vez\n";
          }

          if($partNumbers < 2) {
            $number1 = $tempN;
          } else {
            $number2 = $tempN;
          }
        }
      }
      if($partNumbers == 2) {
        $gearRatio[] = $number1 * $number2;
      }
    } 
  }
}

foreach($gearRatio as $n) {
  $sum += $n;
}

print "The sum is: $sum\n";

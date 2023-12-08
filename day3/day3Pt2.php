<?php
include "fun.php";

$file = file("input");

$dir = [
  [-1,-1], [0,-1], [1,-1],
  [-1, 0],         [1, 0],
  [-1, 1], [0, 1], [1, 1]
];

$sum = 0;
$gearRatios = array();

for($i = 0; $i < count($file); $i++) {
  for($j = 0; $j < strlen($file[$i]); $j++) {
    if($file[$i][$j] == "*") {
      $prevFoundedIn = [-1, -1];
      $partNumbers = 0;
      $number1;
      $number2;

      // Check all the adjacent numbers to the *
      for($k = 0; $k < count($dir); $k++) {
        $adj = getAdjacent($i, $j, $dir[$k], $file);
        if(is_numeric($adj)) {
          if (isTheSameNumber($prevFoundedIn[0], $k)) continue;
          if (isTheSameNumber($prevFoundedIn[1], $k)) continue;

          // Save the position of the last number found
          $prevFoundedIn[$partNumbers] = $k; 
          $partNumbers++;
          // Coordinates of the adjacent number
          $x = $i + $dir[$k][0]; 
          $y = $j + $dir[$k][1];

          $fullPartNumber = getFullPartNumber($x, $y, $adj);

          if($partNumbers < 2) {
            $number1 = $fullPartNumber;
          } else {
            $number2 = $fullPartNumber;
          }
        }
      } // End of the for loop, if we have exactly 2 numbers, we can calculate the gear ratio
      if($partNumbers == 2) {
        $gearRatios[] = $number1 * $number2;
      }
    }
  }
}

foreach($gearRatios as $n) {
  $sum += $n;
}

print "The sum is: $sum\n";

<?php
include "fun.php";
$file = file("input");

$dir = [
  [-1,-1], [0,-1], [1,-1],
  [-1, 0],         [1, 0],
  [-1, 1], [0, 1], [1, 1]
];

$sum = 0;

for($i = 0; $i < count($file); $i++) {
  $tempPartNumber = "";
  $largerNumber = false;
  $isPartNumber = false;
  for($j = 0; $j < strlen($file[$i]); $j++) {
    if(is_numeric($file[$i][$j])) {
      // if we found a number, check if it's part of a larger number
      if(!$largerNumber) $tempPartNumber .= $file[$i][$j];
      $numberAdj = getAdjacent($i, $j, $dir[6], $file);
      if(is_numeric($numberAdj)) {
        $tempPartNumber .= $numberAdj;
        $largerNumber = true;
      }

      // Then, check if it's adjacent it's a part number
      for($k = 0; $k < count($dir); $k++) {
        $adj = getAdjacent($i, $j, $dir[$k], $file);
        if($adj != '.' && $adj != null && !is_numeric($adj) && $adj != "\n") {
          $isPartNumber = true;
        }
      }
    } 
    else if($tempPartNumber != "") { // If we found a non-number, and we have a number, add it to the sum
      if($isPartNumber) { // Add the number to the sum
        $sum += intval($tempPartNumber); 
      }
      // Reset the flags
      $largerNumber = false; 
      $isPartNumber = false;
      $tempPartNumber = ""; 
    }
  }
}

print "The sum is: $sum\n";

<?php 

function getAdjacent(int $i, int $j, array $coords, array $file): ?string {
  [$x, $y] = $coords;
  if($i+$x < 0 || $i+$x >= count($file)) return null;
  if($j+$y < 0 || $j+$y >= strlen($file[$i+$x])) return null;
  return $file[$i + $x][$j + $y];
}

// Function that checks if the number has more than one digit
function getFullPartNumber(int $x, int $y, string $partNumber): string {
  global $file;
  $defY = $y;

  // Check to the right
  while(strlen($file[$x]) > $y+1 && is_numeric($file[$x][$y+1])) {
    $partNumber = $partNumber . $file[$x][$y+1];
    $y++;
  }
  // Check to the left
  while(($defY-1) >= 0 && is_numeric($file[$x][$defY-1])) {
    $partNumber = $file[$x][$defY-1] . $partNumber;
    $defY--;
  }

  return $partNumber;
}

// Function to check if the number is the same as the previous one
function isTheSameNumber(int &$prevFoundedIn, int $k) {
  global $dir;
  if($prevFoundedIn != -1) {
    [$x1, $y1] = $dir[$prevFoundedIn]; // Coordinates of the previous number
    [$x2, $y2] = $dir[$k]; // Coordinates of the current number
    // if the numbers are in the same line and the distance between them is 1, we found the same number again
    if($x1 == $x2 && abs($y1 - $y2) == 1) {
      $prevFoundedIn = $k;
      return true;
    }
    return false;
  }
}

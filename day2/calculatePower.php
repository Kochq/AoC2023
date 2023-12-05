<?php

function calculatePower($rounds) {
  $maxCount = ["blue" => 0, "red" => 0, "green" => 0];
  $power = 1;

  // Iterate through each round of each game
  foreach($rounds as &$round) {
    $round = trim($round);
    $cubes = explode(",", $round);

    // Iterate through each cube in each round
    foreach($cubes as &$cube) {
      $cube = trim($cube);
      [$count, $color] = explode(" ", $cube);
      if($count > $maxCount[$color]) { // This means that the game is impossible
        $maxCount[$color] = $count;
      }
    }
  }

  // Calculate the power of each game
  foreach($maxCount as $color => $count) {
    $power *= $count;
  }

  return $power;
}

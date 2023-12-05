<?php 
/* Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green */
/* Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue */
/* Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red */
/* Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red */
/* Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green */

include 'parseInput.php';

$data = file("input");

$rules = ["blue" => 14, "red" => 12, "green" => 13];
$games = [];
$total = 0;

foreach($data as &$line) {
  [$id, $rounds] = parseInput($line);
  $possible = true;

  foreach($rounds as &$round) {
    $round = trim($round);
    $cubes = explode(",", $round);

    foreach($cubes as &$cube) {
      $cube = trim($cube);
      [$count, $color] = explode(" ", $cube);
      if($rules[$color] < $count) { // This means that the game is impossible
        $possible = false;
      }
    }
  }
  $games[$id] = $possible;
}

foreach ($games as $key => $value) {
  if($value) {
    $total += $key;
  }
}

echo $total;

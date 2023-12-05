<?php 

function parseInput($line) {
  [$id, $gameData] = explode(":", $line);
  $id = explode(" ", $id)[1];
  $rounds = explode(";", $gameData);
  return[$id, $rounds];
}

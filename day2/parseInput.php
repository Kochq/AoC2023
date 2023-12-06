<?php 

function parseInput(String $line) : array {
  [$id, $gameData] = explode(":", $line);
  $id = explode(" ", $id)[1];
  $rounds = explode(";", $gameData);
  return[$id, $rounds];
}

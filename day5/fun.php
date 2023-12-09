<?php

function parseInput(array &$lines, stdClass &$instructions): void {
  $instructions->seeds = explode(' ', trim(explode(':', array_shift($lines))[1]));
  $thing = "";

  foreach($lines as $line) {
    switch($line) {
      case "seed-to-soil map:":
        $thing = "seedSoil";
        continue 2;
        break;
      case "soil-to-fertilizer map:":
        $thing = "soilFertilizer";
        continue 2;
        break;
      case "fertilizer-to-water map:":
        $thing = "fertilizerWater";
        continue 2;
        break;
      case "water-to-light map:":
        $thing = "waterLight";
        continue 2;
        break;
      case "light-to-temperature map:":
        $thing = "lightTemp";
        continue 2;
        break;
      case "temperature-to-humidity map:":
        $thing = "tempHumid";
        continue 2;
        break;
      case "humidity-to-location map:":
        $thing = "humidLocation";
        continue 2;
        break;
      case $line != " ";
        break;
      default:
        continue 2;
        break;
    }
    array_push($instructions->$thing, explode(' ', $line));
  }

}

// This function will retrieve the relation between in and out data
function getMap(array $instructions): array {
  $fullMap = array();

  foreach($instructions as $terms) {
    [$destStart, $srcStart, $len] = $terms;
    $mapped = array();

    for($i = 0; $i < $len; $i++) {
      $mapped[$srcStart+$i] = $destStart+$i;
    }

    $fullMap[] = $mapped;

  }
  return $fullMap;
}

// This function will map the data based on the instructions given
function matchData(array $data, array $instructions): array {
  $maps = getMap($instructions); // Get the 
  $mapData = array();

  // Map the data based on the instructions
  foreach($data as $d) {
    $inserted = false;
    foreach($maps as $map) {
      foreach($map as $src => $dest) {
        if($inserted) break 2;
        if($d == $src) {
          $mapData[] = $dest;
          $inserted = true;
        }
      } 
    }
    if(!$inserted) $mapData[] = $d;
  }

  return $mapData;
}

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

function mapData(array $data, array $instructions): array {
  $mapData = array();

  foreach($data as $d) {
    $isDataMapped = false;
    foreach($instructions as $terms) {
      [$destMin, $srcMin, $len] = $terms;
      $srcMax = $srcMin+$len-1;

      if($d >= $srcMin && $d <= $srcMax) {
        $difference = $d - $srcMin;
        $mapData[] = $destMin + $difference;
        $isDataMapped = true;
        break;
      }
    }
    if(!$isDataMapped) {
      $mapData[] = $d;
    }

  }
  return $mapData;
}

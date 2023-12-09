<?php

function parseInput(array &$lines, stdClass &$instructions): void {
  $seedsT = explode(' ', trim(explode(':', array_shift($lines))[1]));

  for($i = 0; $i < count($seedsT); $i++) {
    if(($i % 2) == 0) {
      $instructions->seeds[] = ["start" => (int) $seedsT[$i], "len" => (int) $seedsT[$i+1]];
    }
  }

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

    if(is_array($d)) {
      $start = $d["start"];
      $length = $d["len"];

      for($k = 0; $k < $length; $k++) {
        $seed = $start + $k;
        $isDataMapped = false;
        foreach($instructions as $terms) {
          [$destMin, $srcMin, $len] = $terms;
          $destMin = (int) $destMin;
          $srcMin = (int) $srcMin;
          $len = (int) $len;
          $srcMax = $srcMin+$len-1;

          if($seed >= $srcMin && $seed <= $srcMax) {
            $difference = $seed - $srcMin;
            $mapData[] = $destMin + $difference;
            $isDataMapped = true;
            break;
          }
        }
        if(!$isDataMapped) {
          $mapData[] = $seed;
        }

      }
    } 

    else {
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
  }
  return $mapData;
}

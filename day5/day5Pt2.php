<?php 

include 'funPt2.php';

$input = file('input', FILE_IGNORE_NEW_LINES);

$instructions = (object) [
  "seeds" => [],
  "seedSoil" => [],
  "soilFertilizer" => [],
  "fertilizerWater" => [],
  "waterLight" => [],
  "lightTemp" => [],
  "tempHumid" => [],
  "humidLocation" => []
];

// Parse the input filling the obj
parseInput($input, $instructions);

$start = microtime(true);

function mapInformation($information) {
  $initialSeeds = $information->seeds;

  $soils = mapData($initialSeeds, $information->seedSoil);
  $fertilizer = mapData($soils, $information->soilFertilizer);
  $water = mapData($fertilizer, $information->fertilizerWater);
  $light = mapData($water, $information->waterLight);
  $temp = mapData($light, $information->lightTemp);
  $humid = mapData($temp, $information->tempHumid);
  $locations = mapData($humid, $information->humidLocation);

  $lowestLocation = $locations[0];
  foreach($locations as $location) {
    if($location < $lowestLocation) $lowestLocation = $location;
  }

  echo "The lowest location is: $lowestLocation\n";
}

mapInformation($instructions);

$end = microtime(true);

echo "\nElapsed time: " . ($end - $start) . "μs\n";

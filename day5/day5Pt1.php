<?php 

include 'fun.php';

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

function mapInformation($information) {
  $initialSeeds = $information->seeds;

  $soils = matchData($initialSeeds, $information->seedSoil);
  $fertilizer = matchData($soils, $information->soilFertilizer);
  $water = matchData($fertilizer, $information->fertilizerWater);
  $light = matchData($water, $information->waterLight);
  $temp = matchData($light, $information->lightTemp);
  $humid = matchData($temp, $information->tempHumid);
  $locations = matchData($humid, $information->humidLocation);

  $low = $locations[0];
  foreach($locations as $location) {
    if($location < $low) $low = $location;
  }

  echo $low;
}

mapInformation($instructions);

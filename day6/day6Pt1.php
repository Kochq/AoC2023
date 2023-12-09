<?php 

$input = file('input', FILE_IGNORE_NEW_LINES);

function parseLine($line) {
  return array_slice(array_values(array_filter(explode(" ", $line))), 1);
}

function parseInput(array $input): array {
  $races = array();

  $times = parseLine($input[0]);
  $distances = parseLine($input[1]);

  for($i = 0; $i < count($times); $i++) {
    $parsedInput = new stdClass();
    $parsedInput->time = $times[$i];
    $parsedInput->distance = $distances[$i];

    $races[] = $parsedInput;
  }

  return $races;
}

function pushTheButton(object $input, int $secs): bool {
  if($secs > $input->time) {
    return false;
  }

  $velocity = $secs;
  $timeLeft = $input->time - $secs;
  $mmTraveled = $velocity * $timeLeft;

  return $mmTraveled >= $input->distance;
}

$races = parseInput($input);

$total = 1;

foreach($races as $race) {
  $waysToWin = 0;
  for($i = 1; $i <= $race->time; $i++) {
    if(pushTheButton($race, $i)) {
      $waysToWin++;
    }
  }
  echo "Times: " . $waysToWin . "\n";

  $total *= $waysToWin;
}

echo $total;

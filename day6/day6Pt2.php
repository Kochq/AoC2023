<?php 

$start = microtime(true);

$input = file('input', FILE_IGNORE_NEW_LINES);

function parseLine($line) {
  return array_slice(array_values(array_filter(explode(" ", $line))), 1);
}

function parseInput(array $input): object {
  $times = parseLine($input[0]);
  $distances = parseLine($input[1]);

  $parsedInput = new stdClass();
  $parsedInput->time = "";
  $parsedInput->distance = "";
  for($i = 0; $i < count($times); $i++) {
    $parsedInput->time .= $times[$i];
    $parsedInput->distance .= $distances[$i];
  }

  return $parsedInput;
}

function pushTheButton(object $input, int $secs): bool {
  if($secs > $input->time) {
    return false;
  }

  $velocity = $secs;
  $timeLeft = $input->time - $secs;
  $mmTraveled = $velocity * $timeLeft;

  return($mmTraveled >= $input->distance);
}

echo "Calculating...\n";

$race = (object) parseInput($input);

$total = 1;
$waysToWin = 0;
for($i = 1; $i <= $race->time; $i++) {
  if(pushTheButton($race, $i)) {
    $waysToWin++;
  }
}

echo "Done!\n\n";
echo "Elapsed time: " . (microtime(true) - $start) . "s\n";

$total *= $waysToWin;

echo "Total way you could win: " . $total;

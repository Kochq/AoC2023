<?php 
include 'fun.php';

$cards = file('input');
$scratchCards = array_fill(0, count($cards), 1);

while($game = getGame($cards)) {
  calculatePoints($game, $scratchCards);
}

$totalScratchCards = array_sum($scratchCards);

echo "Total: " . $totalScratchCards;

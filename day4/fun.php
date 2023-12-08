<?php

function getGame(array &$cards) : ?array {
  $card = array_shift($cards);
  if($card == null) return null;

  [$winnerCard, $myNumbers] = explode('|', $card);
  [$cardId, $winningNumbers] = explode(':', $winnerCard);

  $myNumbers = preg_split('/\s+/', trim($myNumbers));
  $winningNumbers = explode(' ', trim($winningNumbers));
  $cardId = preg_split('/\s+/', trim($cardId))[1];

  return [$cardId, $winningNumbers, $myNumbers];
}

function calculatePoints(array $game, array &$scratchCards): void {
  [$cardId, $winningNumbers, $myNumbers] = $game;
  $matches = $cardId;

  for($i = 0; $i < count($winningNumbers); $i++) {
    for($j = 0; $j < count($myNumbers); $j++) {
      if($myNumbers[$j] == $winningNumbers[$i]) {
        $matches++;
        $scratchCards[$matches] += $scratchCards[$cardId]; // Add matches to a card based on the number of matches of the actual card
      }
    }
  }
}

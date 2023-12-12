<?php

$input = file('input');
$games = array_map(fn($line) => explode(' ', $line), $input);
$rank = ["fiveOfKind" => 7, "fourOfKind" => 6, "fullHouse" => 5, "threeOfKind" => 4, "twoPairs" => 3, "onePair" => 2, "highestCard" => 1];
$total = 0;

function getGameType(string $hand): array {
    $ocurrences = [
        "A" => 0,
        "K" => 0,
        "Q" => 0,
        "J" => 0,
        "T" => 0,
        "9" => 0,
        "8" => 0,
        "7" => 0,
        "6" => 0,
        "5" => 0,
        "4" => 0,
        "3" => 0,
        "2" => 0
    ];

    for($i = 0; $i < strlen($hand); $i++) {
        $ocurrences[$hand[$i]]++;
    }

    $lastFounded = 0;
    $jokers = $ocurrences["J"];
    foreach($ocurrences as $c => $ocurrence) {
        if($c == "J") continue;
        if($ocurrence == 5) {
            return ["fiveOfKind", $jokers];
        }
        if($ocurrence == 4) {
            return ["fourOfKind", $jokers];
        }
        if($ocurrence == 3) {
            if($lastFounded == 2) {
                return ["fullHouse", $jokers];
            }
            $lastFounded = 3;
        }
        if($ocurrence == 2) {
            if($lastFounded == 3) {
                return ["fullHouse", $jokers];
            }
            if($lastFounded == 2) {
                return ["twoPairs", $jokers];
            }
            $lastFounded = 2;
        }
    }
    if($lastFounded == 3) {
        return ["threeOfKind", $jokers];
    }
    if($lastFounded == 2) {
        return ["onePair", $jokers];
    }

    return ["highestCard", $jokers];
}

foreach($games as &$game) {
    [$hand, $bid] = $game;
    $bid = intval($bid);
    $info = getGameType($hand);
    $gameType = $info[0];
    $jokers = $info[1];
    echo "\n";

    echo $hand . " - Before: " . $gameType . " - Jokers: " . $jokers;


    if($jokers == 0 || $gameType == "fiveOfKind") {
        echo " - After: " . $gameType;
        $game = [$hand, $bid, $rank[$gameType]];
        continue;
    }

    if($jokers == 1) {
        if($gameType == "highestCard") {
            echo " - After: " . "onePair";
            $game = [$hand, $bid, $rank["onePair"]];
            continue;
        }
        if($gameType == "onePair") {
            echo " - After: " . "threeOfKind";
            $game = [$hand, $bid, $rank["threeOfKind"]];
            continue;
        }
        if($gameType == "twoPairs") {
            echo " - After: " . "fullHouse";
            $game = [$hand, $bid, $rank["fullHouse"]];
            continue;
        }
        if($gameType == "threeOfKind") {
            echo " - After: " . "fourOfKind";
            $game = [$hand, $bid, $rank["fourOfKind"]];
            continue;
        }
        if($gameType == "fourOfKind") {
            echo " - After: " . "fiveOfKind";
            $game = [$hand, $bid, $rank["fiveOfKind"]];
            continue;
        }
    }

    if($jokers == 2) {
        if($gameType == "highestCard") {
            echo " - After: " . "threeOfKind";
            $game = [$hand, $bid, $rank["threeOfKind"]];
            continue;
        }
        if($gameType == "onePair") {
            echo " - After: " . "fourOfKind";
            $game = [$hand, $bid, $rank["fourOfKind"]];
            continue;
        }
        if($gameType == "threeOfKind") {
            echo " - After: " . "fiveOfKind";
            $game = [$hand, $bid, $rank["fiveOfKind"]];
            continue;
        }
    }

    if($jokers == 3) {
        if($gameType == "highestCard") {
            echo " - After: " . "fourOfKind";
            $game = [$hand, $bid, $rank["fourOfKind"]];
            continue;
        }
        if($gameType == "onePair") {
            echo " - After: " . "fiveOfKind";
            $game = [$hand, $bid, $rank["fiveOfKind"]];
            continue;
        }
    }

    if($jokers == 4) {
        echo " - After: " . "fiveOfKind";
        $game = [$hand, $bid, $rank["fiveOfKind"]];
        continue;
    }

    if($jokers == 5) {
        echo " - After: " . "fiveOfKind";
        $game = [$hand, $bid, $rank["fiveOfKind"]];
        continue;
    }

    $game = [$hand, $bid, $rank[$gameType]];
}

$power = [
    "A" => 13,
    "K" => 12,
    "Q" => 11,
    "T" => 10,
    "9" => 9,
    "8" => 8,
    "7" => 7,
    "6" => 6,
    "5" => 5,
    "4" => 4,
    "3" => 3,
    "2" => 2,
    "J" => 1,
];

for($i = 0; $i < count($games); $i++) {
    $realRank = 1;
    for($j = 0; $j < count($games); $j++) {
        if($i == $j) continue;

        if($games[$i][2] > $games[$j][2]) {
            $realRank++; 
        }

        else if($games[$i][2] == $games[$j][2]) {

            for($k = 0; $k < strlen($games[$i][0]); $k++) {
                if($power[$games[$i][0][$k]] > $power[$games[$j][0][$k]]) {
                    $realRank++;
                    break;
                }
                else if($power[$games[$i][0][$k]] < $power[$games[$j][0][$k]]) {
                    break;
                }
            }

        }

    }
    $games[$i][] = $realRank;
}

for($i = 0; $i < count($games); $i++) {
    $total += $games[$i][1] * $games[$i][3];
}

echo $total;

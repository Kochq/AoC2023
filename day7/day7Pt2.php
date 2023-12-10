<?php

$input = file('input');
$games = array_map(fn($line) => explode(' ', $line), $input);
$rank = ["fiveOfKind" => 7, "fourOfKind" => 6, "fullHouse" => 5, "threeOfKind" => 4, "twoPairs" => 3, "onePair" => 2, "highestCard" => 1];
$total = 0;

function getGameType(string $hand) {
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

    $jokers = $ocurrences["J"];
    if($jokers == 5) {
        return "fiveOfKind";
    }
    if($jokers == 4) {
        return "fourOfKind";
    }
    $lastFounded = 0;
    foreach($ocurrences as $c => $ocurrence) {
        if($c == "J") continue;

        if($ocurrence == 5) {
            return "fiveOfKind";
        }

        if($ocurrence == 4) {
            if($jokers > 0) {
                return "fiveOfKind";
            }
            return "fourOfKind";
        }

        if($ocurrence == 3) {
            if($jokers == 2) {
                return "fiveOfKind";
            }
            if($jokers == 1) {
                return "fourOfKind";
            }
            if($lastFounded == 2) {
                return "fullHouse";
            }
            $lastFounded = 3;
        }

        if($ocurrence == 2) {
            if($jokers == 3) {
                return "fiveOfKind";
            }
            if($jokers == 2) {
                return "fourOfKind";
            }
            if($lastFounded == 3) {
                return "fullHouse";
            }
            if($lastFounded == 2) {
                if($jokers == 1) {
                    return "fullHouse";
                }
                return "twoPairs";
            }
            $lastFounded = 2;
        }

    }


    if($jokers == 5) {
        return "fiveOfKind";
    }
    if($jokers == 4) {
        return "fiveOfKind";
    }
    if($jokers == 3) {
        if($lastFounded == 2) {
            return "fiveOfKind";
        }
        return "fourOfKind";
    }
    if($jokers == 2) {
        if($lastFounded == 3) {
            return "fiveOfKind";
        }
        if($lastFounded == 2) {
            return "fourOfKind";
        }
        return "threeOfKind";
    }
    if($jokers == 0) {
        if($lastFounded == 3) {
            return "threeOfKind";
        }
        if($lastFounded == 2) {
            return "onePair";
        }
        return "highestCard";
    }
    if($jokers == 1) {
        if($lastFounded == 3) {
            return "fourOfKind";
        }
        if($lastFounded == 2) {
            return "threeOfKind";
        }
        return "onePair";
    }

    echo "EH? $hand $jokers\n";

    return "onePair";
}

foreach($games as &$game) {
    [$hand, $bid] = $game;
    $bid = intval($bid);
    $game = [$hand, $bid, $rank[getGameType($hand)]];
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

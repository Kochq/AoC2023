<?php 

$input = file("input", FILE_IGNORE_NEW_LINES);

function parseInput($input) {
    $directions = array_shift($input);
    $parsedInput = array();
    $parsedInput[] = $directions;

    foreach($input as $line) {
        $obj = new stdClass();
        if(!$line) continue; // empty line

        [$node, $dir] = explode("=", $line);
        $node = trim($node);
        [$left, $right] = explode(",", trim($dir));

        $left = substr($left, 1, 3);
        $right = substr(trim($right), 0, 3);

        $obj->node = $node;
        $obj->left = $left;
        $obj->right = $right;

        $parsedInput[] = $obj;
    }

    return $parsedInput;
}

function puzzle($input) {
    $directions = array_shift($input);
    $dirLen = strlen($directions);
    $dirPos = 0;

    $steps = 0;
    $objetiveNode = "AAA";

    for($i = 0; $i < count($input); $i++) {
        $obj = $input[$i];

        if($i == count($input)-1) {
            $i = -1;
        }

        if($obj->node != $objetiveNode) {
            continue;
        }

        if($directions[$dirPos] == "R") {
            $objetiveNode = $obj->right;
        } else {
            $objetiveNode = $obj->left;
        }

        if($objetiveNode == "ZZZ") {
            return $steps+1;
        }

        $steps++;

        $dirPos++;
        if($dirPos == $dirLen) {
            $dirPos = 0;
        }

    }
}

echo puzzle(parseInput($input));

?>

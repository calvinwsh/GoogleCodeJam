<?php
/**
 * Created by PhpStorm.
 * User: calcium.wong
 * Date: 13/4/2017
 * Time: 7:00 PM
 */

const HAPPY = "+";
const UNHAPPY = "-";
const IMPOSSIBLE = "IMPOSSIBLE";

function switchState($currentState){
    $updatedState = "";
    switch ($currentState) {
        case HAPPY :
            $updatedState = UNHAPPY;
            break;

        case UNHAPPY:
            $updatedState = HAPPY;
            break;
    }

    return $updatedState;
}

function flip($state, $flipNumber)
{
    $count = 0;
    $stateArray = str_split($state, 1);
    do {
        $unhappyIdx = array_search(UNHAPPY, $stateArray);
        if ($unhappyIdx !== false) {
            $count++;
            for ($i = 0; $i < $flipNumber; $i++) {
                if (!array_key_exists($unhappyIdx + $i, $stateArray)) {
                    return -1;
                }
                $stateArray[$unhappyIdx + $i] = switchState($stateArray[$unhappyIdx + $i]);
            }
            $unhappyIdx = array_search(UNHAPPY, $stateArray);
            if ($unhappyIdx === false) {
                return $count;
            }
        } else {
            return $count;
        }
    } while (true);

    return -1;
}

$totalLine = trim(fgets(STDIN));

for ($i = 1; $i <= $totalLine; $i++) {
    $line = trim(fgets(STDIN));
    $separator = explode(" ", $line);
    $result = flip($separator[0], $separator[1]);

    echo "Case #" . $i . ": " . ($result == -1 ? IMPOSSIBLE : $result) . PHP_EOL;
}
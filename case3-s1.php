<?php
/**
 * Created by PhpStorm.
 * User: calcium.wong
 * Date: 14/4/2017
 * Time: 1:06 AM
 */
const LHS = "LHS";
const RHS = "RHS";
const DIFF = "DIFF";

const SMALLEST_DIFF = "SD";
const LARGEST_DIFF = "LD";

function getMaxDistance($stallList) {
    $occupiedStallKeyList = array_keys($stallList);
    sort($occupiedStallKeyList);
    $return = array(DIFF => 0, LHS => 0, RHS => 0);
    for ($i = 0; $i < (sizeof($occupiedStallKeyList) - 1); $i++) {
        $diff = $occupiedStallKeyList[$i + 1] - $occupiedStallKeyList[$i];
        if ($diff > $return[DIFF]) {
            $return[DIFF] = $diff;
            $return[LHS] = $occupiedStallKeyList[$i];
            $return[RHS] = $occupiedStallKeyList[$i + 1];
        }
    }

    return $return;
}

function calculateLastDistance($stallList, $pivot) {
    $occupiedStallKeyList = array_keys($stallList);
    sort($occupiedStallKeyList);
    $pivotIdx = array_search($pivot, $occupiedStallKeyList);
    $lhsDiff = $pivot - $occupiedStallKeyList[$pivotIdx - 1] - 1;
    $rhsDiff = $occupiedStallKeyList[$pivotIdx + 1] - $pivot - 1;
    $return[SMALLEST_DIFF] = ($rhsDiff > $lhsDiff) ? $lhsDiff : $rhsDiff;
    $return[LARGEST_DIFF] = ($rhsDiff > $lhsDiff) ? $rhsDiff : $lhsDiff;
    return $return;
}

function getOccupiedDistance($numberOfStalls, $numberOfPeople)
{
    if ($numberOfStalls == $numberOfPeople) {
        return array(SMALLEST_DIFF => 0, LARGEST_DIFF => 0);
    }

    $stallList = array();
    $totalOfStalls = $numberOfStalls + 2;
    $stallList[0] = true;
    $stallList[$totalOfStalls - 1] = true;
    $finalKey = 0;

    for($i = 1; $i <= $numberOfPeople; $i++) {
        $maxDistance = getMaxDistance($stallList);
        $finalKey = $maxDistance[LHS] + floor(($maxDistance[DIFF] / 2));
        $stallList[$finalKey] = true;

    }

    return calculateLastDistance($stallList, $finalKey);
}

$totalLine = trim(fgets(STDIN));
for ($i = 1; $i <= $totalLine; $i++) {
    $line = trim(fgets(STDIN));

    $separatedArg = explode(" ", $line);
    $result = getOccupiedDistance($separatedArg[0], $separatedArg[1]);

    echo "Case #" . $i . ": " . $result[LARGEST_DIFF] . " " . $result[SMALLEST_DIFF] . PHP_EOL;
}

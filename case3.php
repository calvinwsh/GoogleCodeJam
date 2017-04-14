<?php
/**
 * Created by PhpStorm.
 * User: calcium.wong
 * Date: 14/4/2017
 * Time: 1:06 AM
 */
const LHS = "LHS";
const RHS = "RHS";
const IDX = "IDX";
const DIFF = "DIFF";

const SMALLEST_DIFF = "SD";
const LARGEST_DIFF = "LD";

function logger($message)
{
    echo $message . PHP_EOL;

}

function getMaxDistance(&$i, &$stallList, $maxCount)
{
    $i--;
    $stallKeyList = array_keys($stallList);
    asort($stallKeyList);
    asort($stallList);
    $maxDiffValue = end($stallList);
    $maxDiffKeyList = array_keys($stallList, $maxDiffValue);
    asort($maxDiffKeyList);
    foreach ($maxDiffKeyList as $maxDiffKey) {
        $newKey = $maxDiffKey + ceil(($maxDiffValue / 2));
        $nextKey = $stallKeyList[array_search($maxDiffKey, $stallKeyList) + 1];
        $stallList[$maxDiffKey] = $newKey - $maxDiffKey - 1;
        $stallList[$newKey] = $nextKey - $newKey - 1;
        $i++;
        if ($i >= $maxCount) {
            return $newKey;
        }
    }
    return 0;
}

function getLastDistance($stallList, $pivot) {
    ksort($stallList);
    $keyList = array_keys($stallList);
    asort($keyList);
    $keyListIdx = array_search($pivot, $keyList);
    $lhs = $keyList[$keyListIdx - 1];
    $rhs = $keyList[$keyListIdx + 1];
    $return[LHS] = $pivot - $lhs - 1;
    $return[RHS] = $rhs - $pivot - 1;
    return $return;
}

function getStallListLastDistance($numberOfStall, $numberOfPeople)
{
    if ($numberOfStall == $numberOfPeople) {
        return array(SMALLEST_DIFF => 0, LARGEST_DIFF => 0);
    }

    $stallList = array();
    $stallList[0] = $numberOfStall;
    $stallList[$numberOfStall + 1] = 0;
    $finalKey = 0;

    for ($i = 1; $i <= $numberOfPeople; $i++) {
        logger("Try : " . $i);
        $finalKey = getMaxDistance($i, $stallList, $numberOfPeople);
        ksort($stallList);
    }

    return getLastDistance($stallList, $finalKey);

}


//$totalLine = trim(fgets(STDIN));
//for ($i = 1; $i <= $totalLine; $i++) {
//    $line = trim(fgets(STDIN));
//
//    $separatedArg = explode(" ", $line);
//    $distance = getStallListLastDistance($separatedArg[0], $separatedArg[1]);
//
//    echo "Case #" . $i . ": " . max($distance) . " " . min($distance) . PHP_EOL;
//}

echo json_encode(getStallListLastDistance(949792, 714292)) . PHP_EOL;
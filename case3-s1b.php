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

function getMaxDistance($stallList) {
    $keyList = array_keys($stallList);
    asort($keyList);
    asort($stallList);
    $maxDiffValue = end($stallList);
//    echo "A : " . $maxDiffValue . PHP_EOL;
    $maxDiffKeyList = array_keys($stallList, $maxDiffValue);
    sort($maxDiffKeyList);
//    echo "A : " . json_encode($maxDiffKeyList) . PHP_EOL;
    $maxDiffIdx = current($maxDiffKeyList);
    $keyListIdx = array_search($maxDiffIdx, $keyList);
//    echo "A : " . $keyListIdx . PHP_EOL;
//    echo "A : " . json_encode($keyList) . PHP_EOL;


    if ($keyListIdx == (sizeof($keyList) - 1)) {
        $return[DIFF] = $maxDiffValue;
        $return[IDX] = ($keyListIdx === 0) ? $keyListIdx : $keyList[$keyListIdx - 1];
    } else {
        if (($maxDiffIdx - $keyList[$keyListIdx - 1]) >= ($keyList[$keyListIdx + 1] - $maxDiffIdx)) {
            $return[DIFF] = $maxDiffIdx - $keyList[$keyListIdx - 1] - 1;
            $return[IDX] = $keyList[$keyListIdx - 1];
        } else {
            $return[DIFF] = $keyList[$keyListIdx + 1] - $maxDiffIdx - 1;
            $return[IDX] = $maxDiffIdx;
        }
    }

//    echo "B : " . json_encode($return) . PHP_EOL;

    return $return;
}

function updateDistance(&$stallList, $pivot) {
    ksort($stallList);
//    echo "C : " . json_encode($stallList, true) . PHP_EOL;
    $keyList = array_keys($stallList);
    asort($keyList);
    $keyListIdx = array_search($pivot, $keyList);
    $lhs = $keyList[$keyListIdx - 1];
    $llhs = ($keyListIdx - 2 <= 0)? 0 : $keyList[$keyListIdx - 2];
    $rhs = $keyList[$keyListIdx + 1];
    $rrhs = ($keyListIdx + 2 >= (sizeof($keyList) - 1)) ? $keyList[$keyListIdx + 1] : $keyList[$keyListIdx + 2];
//    echo "C : " . $lhs . " " . $llhs . " " . $rhs . " " . $rrhs. PHP_EOL;
    $stallList[$lhs] = max(($pivot - $lhs - 1), ($lhs - $llhs - 1));
    $stallList[$rhs] = max(($rhs - $pivot - 1), ($rrhs - $rhs - 1));
    $stallList[$pivot] = max(($pivot - $lhs - 1), ($rhs - $pivot - 1));
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

function getStallListLastDistance($numberOfStalls, $numberOfPeople)
{
    if ($numberOfStalls == $numberOfPeople) {
        return array(SMALLEST_DIFF => 0, LARGEST_DIFF => 0);
    }

    $stallList = array();
    $stallList[0] = $numberOfStalls;
    $stallList[$numberOfStalls + 1] = $numberOfStalls;
    $finalKey = 0;

    for($i = 1; $i <= $numberOfPeople; $i++) {
//        echo $i . PHP_EOL;
        $maxDistance = getMaxDistance($stallList);
        $finalKey = $maxDistance[IDX] + ceil(($maxDistance[DIFF] / 2));
        $stallList[$finalKey] = true;
//        echo json_encode($stallList) . PHP_EOL;
        updateDistance($stallList, $finalKey);
//        echo json_encode($stallList) . PHP_EOL;
    }

    return getLastDistance($stallList, $finalKey);
}

$totalLine = trim(fgets(STDIN));
for ($i = 1; $i <= $totalLine; $i++) {
    $line = trim(fgets(STDIN));

    $separatedArg = explode(" ", $line);
    $distance = getStallListLastDistance($separatedArg[0], $separatedArg[1]);

    echo "Case #" . $i . ": " . max($distance) . " " . min($distance) . PHP_EOL;
}

//echo json_encode(getStallListLastDistance(20, 10)) . PHP_EOL;
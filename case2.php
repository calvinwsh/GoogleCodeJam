<?php
/**
 * Created by PhpStorm.
 * User: calcium.wong
 * Date: 13/4/2017
 * Time: 7:00 PM
 */

function isTidyNumber($number)
{
    $charArray = str_split($number, 1);
    if (sizeof($charArray) == 1) {
        return true;
    }

    for ($i = (sizeof($charArray) - 1); $i >= 0; $i--) {
        if ($charArray[$i] < $charArray[$i - 1]) {
            return false;
        }
    }

    return true;
}


function getTidyNumber($number)
{
    if ($number >= pow(10, 18)) {
        $number = pow(10, 18);
    }

    while (!isTidyNumber($number)) {
        $charArray = str_split($number, 1);
        if ($number % 10 == 0) {
            $number--;
        } else {
            for ($i = (sizeof($charArray) - 1); $i >= 0; $i--) {
                if ($charArray[$i] < $charArray[$i - 1]) {
                    $number -= pow(10, (sizeof($charArray) - $i - 1));
                    $newCharArray = str_split($number, 1);
                    for ($k = ((sizeof($newCharArray) != sizeof($charArray)) ? 0 : $i); $k < (sizeof($newCharArray) - 1); $k++) {
                        if ($newCharArray[$k] > $newCharArray[$k + 1]) {
                            $newCharArray[$k + 1] = $newCharArray[$k];
                        }
                    }
                    $number = implode("", $newCharArray);
                }
            }
        }

    }

    return $number;
}

$totalLine = trim(fgets(STDIN));
for ($i = 1; $i <= $totalLine; $i++) {
    $line = trim(fgets(STDIN));

    echo "Case #" . $i . ": " . getTidyNumber($line) . PHP_EOL;
}
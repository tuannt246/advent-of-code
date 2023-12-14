<?php

const NUMBER_KEY_BY_LETTERS = [
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
    'six' => 6,
    'seven' => 7,
    'eight' => 8,
    'nine' => 9,
];

define("NUMBER_BY_LETTERS", array_keys(NUMBER_KEY_BY_LETTERS));

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function findFirstNumberFromBothSide($string): int
{
    $left = 0;
    $right = strlen($string) - 1;
    $foundLeft = false;
    $foundRight = false;
    $leftVal = $rightVal = 0;
    while (!($foundLeft && $foundRight)) {
        if (!$foundLeft && is_numeric($string[$left])) {
            $leftVal = $string[$left];
            $foundLeft = true;
        }

        if (!$foundRight && is_numeric($string[$right])) {
            $rightVal = $string[$right];
            $foundRight = true;
        }
        $left++;
        $right--;
    }

    return '' . $leftVal . $rightVal;
}

function findFirstNumberFromBothSideWithString($string): int
{
    $left = 0;
    $right = strlen($string) - 1;
    $foundLeft = false;
    $foundRight = false;
    $leftVal = $rightVal = 0;
    $leftValArr = [];
    $rightValArr = [];

    while (!($foundLeft && $foundRight)) {
        if (!$foundLeft) {
            if (is_numeric($string[$left])) {
                $leftVal = $string[$left];
                $foundLeft = true;
            }

            $leftValArr[] = $string[$left];
            if (count($leftValArr) > 2) {
                $val = implode('', $leftValArr);
                foreach (NUMBER_BY_LETTERS as $letters) {
                    if (strpos($val, $letters) !== false) {
                        $leftVal = NUMBER_KEY_BY_LETTERS[$letters];
                        $foundLeft = true;
                    }
                }
            }

        }


        if (!$foundRight) {
            if (is_numeric($string[$right])) {
                $rightVal = $string[$right];
                $foundRight = true;
            }

            array_unshift($rightValArr, $string[$right]);
            if (count($rightValArr) > 2) {
                $val = implode('', $rightValArr);
                foreach (NUMBER_BY_LETTERS as $letters) {
                    if (strpos($val, $letters) !== false) {
                        $rightVal = NUMBER_KEY_BY_LETTERS[$letters];
                        $foundRight = true;
                    }
                }
            }
        }


        $left++;
        $right--;
    }
    return '' . $leftVal . $rightVal;
}

function printResult($result)
{
    echo "--- Day 1: Trebuchet ---" . "\n";

    echo "The sum of all of the calibration values only by numbers is {$result[0]} ." . "\n";

    echo "The sum of all of the calibration values by numbers or letters is {$result[1]} ." . "\n";
}

function dayOne($fileName)
{
    $dataStream = readFileContents($fileName);
    $part1 = $part2 = 0;
    foreach ($dataStream as $data) {
        $part1 += findFirstNumberFromBothSide($data);
    }

    foreach ($dataStream as $data) {
        $part2 += findFirstNumberFromBothSideWithString($data);
    }

    printResult([$part1, $part2]);
}

dayOne("input.txt");


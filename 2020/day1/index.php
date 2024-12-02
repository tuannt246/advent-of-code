<?php

const SUM = 2020;

dayOne("input.txt");

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function dayOne($fileName)
{
    $dataStream = readFileContents($fileName);
    sort($dataStream);
    $first = $second = 0;
    $left = 0;
    $right = count($dataStream) - 1;

    while ($left < $right) {
        $sum = $dataStream[$left] + $dataStream[$right];
        if ($sum == SUM) {
            $first = $dataStream[$left] * $dataStream[$right];
            break;
        } else if ($sum < SUM) {
            $left++;
        } else {
            $right--;
        }
    }

    $left = 0;
    while ($left < $right) {
        $middle = $left + 1;
        $right = count($dataStream) - 1;
        while ($middle < $right) {
            $sum = $dataStream[$left] + $dataStream[$middle] + $dataStream[$right];
            if ($sum == SUM) {
                $second = $dataStream[$left] * $dataStream[$middle] * $dataStream[$right];
                break;
            } else if ($sum < SUM) {
                $middle++;
            } else {
                $right--;
            }
        }
        $left++;
    }

    printResult($first, $second);
}

function printResult($first, $second)
{
    echo "--- Day 1: Report Repair ---" . "\n";

    echo "The product of the two entries that sum to 2020 is {$first}." . "\n";

    echo "The product of the three entries that sum to 2020 is {$second}." . "\n";
}





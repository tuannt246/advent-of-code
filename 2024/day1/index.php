<?php
dayOne("input.txt");

function dayOne($fileName)
{
    $lines = readFileContents($fileName);
    list($first, $second) = twoLists($lines);
    printResult($first, $second);
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function twoLists($dataStream): array
{
    $left = $right = [];
    foreach ($dataStream as $row) {
        $row = explode(" ", $row);
        $row = array_values(array_filter($row));
        $left[] = $row[0];
        $right[] = $row[1];
    }
    sort($left);
    sort($right);

    $distance = 0;
    foreach ($left as $key => $item) {
        $distance += abs($item - $right[$key]);
    }

    $sum = 0;
    $rightCounter = array_count_values($right);  // initial solution was using hash map
    foreach ($left as $value) {
        if (isset($rightCounter[$value])) {
            $sum += $rightCounter[$value] * $value;
        }
    }

    return [$distance, $sum];
}

function printResult($first, $second)
{
    echo "--- Day 1: Historian Hysteria ---" . "\n";

    echo "The total distance between the lists is {$first}." . "\n";

    echo "The similarity score of the lists is {$second}." . "\n";
}
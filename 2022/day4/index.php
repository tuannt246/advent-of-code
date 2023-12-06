<?php

dayFour("input.txt");

function dayFour($fileName)
{
    $lines = readFileContents($fileName);
    $result = calculateOverlapPairs($lines);
    printResult($result);
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function calculateOverlapPairs($lines): array
{
    $countFullyContainAssignmentPairs = 0;
    $countOverlapAssignmentPairs = 0;

    foreach ($lines as $line) {
        $pairs = explode(',', $line);
        $first = explode('-', $pairs[0]);
        $second = explode('-', $pairs[1]);

        if ($first[0] < $second[0]) {
            if ($first[1] >= $second[1]) {
                $countFullyContainAssignmentPairs++;
            }
            if ($first[1] >= $second[0]) {
                $countOverlapAssignmentPairs++;
            }
        } else if ($first[0] == $second[0]) {
            $countFullyContainAssignmentPairs++;
            $countOverlapAssignmentPairs++;
        } else {
            if ($first[1] <= $second[1]) {
                $countFullyContainAssignmentPairs++;
            }
            if ($first[0] <= $second[1]) {
                $countOverlapAssignmentPairs++;
            }
        }
    }

    return [$countFullyContainAssignmentPairs, $countOverlapAssignmentPairs];
}

function printResult($result)
{
    echo "--- Day 4: Camp Cleanup ---" . "\n";

    echo "The number of pairs one range fully contain the other is {$result[0]}." . "\n";

    echo "The number of pairs the ranges overlap is {$result[1]}." . "\n";
}
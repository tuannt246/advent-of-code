<?php

function daySix($fileName)
{
    $dataStream = readFileContents($fileName);
    $time = explode(' ', $dataStream[0]);
    $time = array_values(array_filter($time, "is_numeric"));
    $distance = explode(' ', $dataStream[1]);
    $distance = array_values(array_filter($distance, "is_numeric"));

    $result = 1;
    for ($raceId = 0; $raceId < count($time); $raceId++) {
        $result *= findOptimizeTimeToWinRace($time[$raceId], $distance[$raceId]);
    }

    $totalTime = implode('', $time);
    $totalDistance = implode('', $distance);
    findOptimizeTimeToWinRace($totalTime, $totalDistance);
    printResult($result);
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function findOptimizeTimeToWinRace($time, $distance): int
{
    $ways = 0;
    $middle = (int)$time / 2;
    for ($middle; $middle < $time; $middle++) {
        if (($middle * ($time - $middle)) > $distance) {
            $ways++;
        } else {
            break;
        }
    }
    return ($ways * 2) - 1;
}

function printResult($result)
{
    echo "--- Day 6: Wait For It ---" . "\n";

    echo "The number of ways you could beat the record in each race is {$result} ." . "\n";

}

daySix("input.txt");


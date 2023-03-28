<?php

function dayOne($fileName)
{
    $calories = readFileContents($fileName);

    $caloriesCarriedByElves = findTotalCaloriesCarriedByElves($calories);

    $theMostCaloriesByElf = $caloriesCarriedByElves[0];

    $theMostCaloriesByThreeElves =
        $caloriesCarriedByElves[0] +
        $caloriesCarriedByElves[1] +
        $caloriesCarriedByElves[2];

    $result = [$theMostCaloriesByElf, $theMostCaloriesByThreeElves];

    printResult($result);
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES);
}

function findTotalCaloriesCarriedByElves($calories): array
{
    $totalCaloriesByElf = 0;
    $caloriesCarriedByElves = [];

    foreach ($calories as $calorie) {
        if (!$calorie) {
            $caloriesCarriedByElves[] = $totalCaloriesByElf;
            $totalCaloriesByElf = 0;
        } else {
            $totalCaloriesByElf += $calorie;
        }
    }

    rsort($caloriesCarriedByElves);

    return $caloriesCarriedByElves;
}

function printResult($result)
{
    echo "--- Day 1: Calorie Counting ---" . "\n";

    echo "The most Calories carrying by that Elf is " . $result[0] . "\n";

    echo "The most Calories carrying by the top three Elves is " . $result[1] . "\n";
}

dayOne("input.txt");
<?php

dayThree("input.txt");

function dayThree($fileName)
{
    $dataStream = readFileContents($fileName);
    list($first, $second) = findSumOfNumbersAdjacentSymbol($dataStream);
    printResult($first, $second);
}

function findSumOfNumbersAdjacentSymbol($schematic): array
{
    $sum = 0;
    $current = '';
    $isAdjacent = false;
    $ratio = [];
    foreach ($schematic as $row => $line) {
        if ($isAdjacent && !empty($current)) {
            $sum += (int)$current;
        }
        $current = '';
        $isAdjacent = false;
        foreach (str_split($line) as $column => $char) {
            if ((is_numeric($char))) {
                if (!$isAdjacent) {
                    $isAdjacent = isAdjacentSymbol($row, $column, $schematic);
                }
                $current .= $char;
            } else {
                if ($isAdjacent) {
                    $sum += (int)$current;
                }
                $current = '';
                $isAdjacent = false;
            }
        }
    }

    return [$sum, 0];
}

function isAdjacentSymbol($row, $column, $table): bool
{
    $directions = [
        [-1, -1], [-1, 0], [-1, 1],
        [0, -1], [0, 1],
        [1, -1], [1, 0], [1, 1]
    ];

    foreach ($directions as [$dr, $dc]) {
        $newRow = $row + $dr;
        $newColumn = $column + $dc;
        if ($newRow < 0 || $newRow >= count($table) || $newColumn < 0 || $newColumn >= strlen($table[$row])) {
            continue;
        }

        if ($table[$newRow][$newColumn] != '.' && !is_numeric($table[$newRow][$newColumn])) {
            return true;
        }
    }
    return false;
}


function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function printResult($first, $second)
{
    echo "--- Day 3: Gear Ratios ---" . "\n";

    echo "The sum of all of the calibration values only by numbers is {$first}." . "\n";
}
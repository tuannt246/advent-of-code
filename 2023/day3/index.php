<?php

const DIRECTIONS = [
    [-1, -1], [-1, 0], [-1, 1],
    [0, -1], [0, 1],
    [1, -1], [1, 0], [1, 1]
];

dayThree("input.txt");

function dayThree($fileName)
{
    $dataStream = readFileContents($fileName);
    $first = findSumOfAdjacentSymbol($dataStream);
    $second = findSumOfGearRatios($dataStream);
    printResult($first, $second);
}

function findSumOfAdjacentSymbol($schematic): int
{
    $sum = 0;
    $rowLength = count($schematic);
    $columnLength = strlen($schematic[0]);
    foreach ($schematic as $row => $line) {
        $current = '';
        $isAdjacent = false;
        foreach (str_split($line) as $column => $char) {
            if ((is_numeric($char))) {
                if (!$isAdjacent) {
                    foreach (DIRECTIONS as [$dr, $dc]) {
                        $newRow = $row + $dr;
                        $newColumn = $column + $dc;
                        if ($newRow < 0 || $newRow >= $rowLength || $newColumn < 0 || $newColumn >= $columnLength) {
                            continue;
                        }

                        if ($schematic[$newRow][$newColumn] != '.' && !is_numeric($schematic[$newRow][$newColumn])) {
                            $isAdjacent = true;
                            break;
                        }
                    }
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
        if ($isAdjacent) {
            $sum += (int)$current;
        }
    }

    return $sum;
}

function findSumOfGearRatios($schematic)
{
    $ratios = [];
    $rowLength = count($schematic);
    $columnLength = strlen($schematic[0]);
    foreach ($schematic as $row => $line) {
        $current = '';
        $gearPositions = [];
        $ratio = null;
        foreach (str_split($line) as $column => $char) {
            if ((is_numeric($char))) {
                $current .= $char;
                foreach (DIRECTIONS as [$dr, $dc]) {
                    $newRow = $row + $dr;
                    $newColumn = $column + $dc;
                    if ($newRow < 0 || $newRow >= $rowLength || $newColumn < 0 || $newColumn >= $columnLength) {
                        continue;
                    }

                    if ($schematic[$newRow][$newColumn] == '*') {
                        $ratio = "$newRow-$newColumn";
                        break;
                    }
                }
                if (isset($ratio)) {
                    $gearPositions[] = $ratio;
                }
            } else {
                if (!empty($current)) {
                    foreach (array_unique($gearPositions) as $gearPos) {
                        $ratios[$gearPos][] = intval($current);
                    }
                }
                $gearPositions = [];
                $current = '';
                $ratio = null;
            }
        }
        if (!empty($current)) {
            foreach (array_unique($gearPositions) as $gearPos) {
                $ratios[$gearPos][] = intval($current);
            }
        }
    }
    $product = 0;
    foreach ($ratios as $values) {
        if (count($values) == 2) {
            $product += array_product($values);
        }
    }
    return $product;
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function printResult($first, $second)
{
    echo "--- Day 3: Gear Ratios ---" . "\n";

    echo "The sum of all of the part numbers in the engine schematic is {$first}." . "\n";

    echo "The sum of all of the gear ratios in your engine schematic is {$second}." . "\n";
}
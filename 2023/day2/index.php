<?php

const MAX_CUBES_OF = [
    'red' => 12,
    'green' => 13,
    'blue' => 14,
];

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function findGameId($gameInput): int
{
    $game = explode(':', $gameInput);
    $gameId = explode(' ', $game[0])[1];
    $sets = explode(';', $game[1]);


    foreach ($sets as $set) {
        $cubes = [
            'red' => 0,
            'green' => 0,
            'blue' => 0,
        ];
        $bags = explode(',', $set);
        foreach ($bags as $bag) {
            $cube = explode(' ', $bag);
            $cubes[$cube[2]] += $cube[1];
            if ($cubes[$cube[2]] > MAX_CUBES_OF[$cube[2]]) {
                return 0;
            }
        }
    }

    return $gameId;
}

function findProductOfMinimumCubes($gameInput): int
{
    $game = explode(':', $gameInput);
    $sets = explode(';', $game[1]);

    $cubes = [
        'red' => 0,
        'green' => 0,
        'blue' => 0,
    ];
    foreach ($sets as $set) {
        $bags = explode(',', $set);
        foreach ($bags as $bag) {
            $cube = explode(' ', $bag);
            if ($cubes[$cube[2]] < $cube[1]) {
                $cubes[$cube[2]] = $cube[1];
            }
        }
    }

    return array_product($cubes);
}

function printResult($result)
{
    echo "--- Day 2: Cube Conundrum ---" . "\n";

    echo "The sum of the IDs of those games is {$result[0]}." . "\n";

    echo "The sum of the power of these sets is {$result[1]}." . "\n";
}

function dayTwo($fileName)
{
    $dataStream = readFileContents($fileName);

    $part1 = $part2 = 0;
    foreach ($dataStream as $data) {
        $part1 += findGameId($data);
    }
    var_dump($part1);

    foreach ($dataStream as $data) {
        $part2 += findProductOfMinimumCubes($data);
    }

    printResult([$part1, $part2]);
}

dayTwo("input.txt");


<?php

dayTwo("input.txt");

function dayTwo($fileName)
{
    $dataStream = readFileContents($fileName);

    $part1 = $part2 = 0;
    foreach ($dataStream as $data) {
        $input = explode(': ', $data);
        $policy = explode(' ', $input[0]);
        $range = explode('-', $policy[0]);

        $totalCharacters = substr_count($input[1], $policy[1]);
        if ($range[0] <= $totalCharacters && $totalCharacters <= $range[1]) {
            $part1++;
        }

        $first = $input[1][$range[0] - 1] == $policy[1];
        $second = $input[1][$range[1] - 1] == $policy[1];

        if ($first) {
            if (!$second) {
                $part2++;
            }
        } else {
            if ($second) {
                $part2++;
            }
        }
    }

    printResult($part1, $part2);
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function printResult($first, $second)
{
    echo "--- Day 2: Password Philosophy ---" . "\n";

    echo "Number of valid passwords according to the first policies are {$first}." . "\n";

    echo "Number of valid passwords according to the second policies are {$second}." . "\n";
}



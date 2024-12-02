<?php

dayOne("input.txt");

function dayOne($fileName)
{
    $dataStream = readFileContents($fileName);
    $len = count($dataStream) - 1;
    $first = $second = 0;

    for ($i = 0; $i < $len; $i++) {
        if ($dataStream[$i] < $dataStream[$i + 1]) {
            $first += 1;
        }

        $j = $i + 3;
        if ($j <= $len && ($dataStream[$i] < $dataStream[$j])) {
            $second += 1;
        }
    }

    printResult($first, $second);
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function printResult($first, $second)
{
    echo "--- Day 1: Sonar Sweep ---" . "\n";

    echo "There are {$first} measurements larger than the previous measurement." . "\n";

    echo "There are {$second} sums larger than the previous sum." . "\n";
}
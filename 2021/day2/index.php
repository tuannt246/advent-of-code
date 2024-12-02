<?php

dayTwo("input.txt");
function dayTwo($fileName)
{
    $dataStream = readFileContents($fileName);

    $units = [
        'forward' => 0,
        'down' => 0,
        'up' => 0,
    ];
    foreach ($dataStream as $data) {
        $command = explode(" ", $data);
        $units[$command[0]] += $command[1];
    }
    $first = $units['forward'] * ($units['down'] - $units['up']);

    $units = [
        'forward' => 0,
        'down' => 1,
        'up' => -1,
        'depth' => 0,
        'aim' => 0,
    ];
    foreach ($dataStream as $data) {
        $command = explode(" ", $data);
        if ($command[0] == 'forward') {
            $units['depth'] += ($units['aim'] * $command[1]);
            $units['forward'] += $command[1];
        } else {
            $units['aim'] += ($units[$command[0]] * $command[1]);
        }
    }
    $second = $units['forward'] * $units['depth'];

    printResult($first, $second);
}


function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function printResult($first, $second)
{
    echo "--- Day 2: Dive! ---" . "\n";

    echo "The product when multiply your final horizontal position by your final depth is {$first}." . "\n";

    echo "The product when multiply your final horizontal position by your final depth by new interpretation " .
        "is {$second}." . "\n";
}


<?php

dayThree("input.txt");

function dayThree($fileName)
{
    $lines = readFileContents($fileName);
    list($first, $second) = countBits($lines);
    printResult($first, $second);
}

function countBits($dataStream): array
{
    $numberLength = strlen($dataStream[0]);
    $counter = counterBinaryBit($numberLength);

    foreach ($dataStream as $data) {
        foreach (str_split($data) as $key => $char) {
            $counter[$key][$char]++;
        }
    }

    $mcb = $lcb = '';
    foreach ($counter as $column) {
        if ($column[1] > $column[0]) {
            $mcb .= '1';
            $lcb .= '0';
        } else {
            $mcb .= '0';
            $lcb .= '1';
        }

    }
    $first = bindec($mcb) * bindec($lcb);

    $dataStream2 = $dataStream;
    $index = 0;
    while (true) {
        filterBit($dataStream, $counter, $index, 'LCB');
        $index++;
        if (count($dataStream) == 1) {
            $lcb = $dataStream[0];
            break;
        }
    }

    $index = 0;
    while (true) {
        filterBit($dataStream2, $counter, $index, 'MCB');
        $index++;
        if (count($dataStream2) == 1) {
            $mcb = $dataStream2[0];
            break;
        }
    }

    return [$first, bindec($mcb) * bindec($lcb)];
}

function counterBinaryBit($length): array
{
    $counter = [];
    for ($i = 0; $i < $length; $i++) {
        $counter[$i][0] = 0;
        $counter[$i][1] = 0;
    }

    return $counter;
}

function filterBit(&$string, &$counter, $idx, $type)
{
    $index = [];
    $counter[$idx][0] = 0;
    $counter[$idx][1] = 0;
    foreach ($string as $key => $stringBit) {
        $counter[$idx][$stringBit[$idx]]++;
        $index[$stringBit[$idx]][] = $key;
    }
    if ($type == 'LCB') {
        $bit = $counter[$idx][0] > $counter[$idx][1] ? 1 : 0;
    } else {
        $bit = $counter[$idx][0] > $counter[$idx][1] ? 0 : 1;
    }
    $string = array_values(array_diff_key($string, array_flip($index[$bit] ?? [])));
}


function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function printResult($first, $second)
{
    echo "--- Day 3: Binary Diagnostic ---" . "\n";

    echo "The power consumption of the submarine is {$first}." . "\n";

    echo "The life support rating of the submarine is {$second}." . "\n";
}





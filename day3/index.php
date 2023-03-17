<?php

echo "part1: " . part1("input.txt");

print "\n";

echo "part2: " . part2("input.txt");

function findDuplicateChar($string)
{
    $first_half = substr($string, 0, (strlen($string) / 2));
    $second_half = substr($string, (strlen($string) / 2));
    $hash = array();
    foreach (str_split($first_half) as $char) {
        $hash[$char] = 1;
    }

    foreach (str_split($second_half) as $char) {
        if ($hash[$char]) {
            return $char;
        }
    }
}

function calculatePriority($item)
{
    if (ctype_lower($item)) {
        return ord($item) - 96;
    } else {
        return ord($item) - 38;
    }
}


function part1($file_name)
{
    $file_input = fopen($file_name, "r");
    $sum = 0;

    while (!feof($file_input)) {
        $content = fgets($file_input);
        $char = findDuplicateChar($content);
        $sum += calculatePriority($char);
    }

    fclose($file_input);
    return $sum;
}

function part2($file_name)
{
    $contents = file($file_name);
    $sum = 0;

    foreach (array_chunk($contents, 3) as $groups) {
        $hash = array();
        foreach ($groups as $key => $row) {

            for ($index = 0; $index < strlen($row); $index++) {
                if ($key == 0) {
                    $hash[$row[$index]] = 1;
                } else if ($key == 1) {
                    if ($hash[$row[$index]] == 1) {
                        $hash[$row[$index]] = 2;
                    }
                } else {
                    if ($hash[$row[$index]] == 2) {
                        $sum += calculatePriority($row[$index]);
                        break;
                    }
                }
            }

        }
    }

    return $sum;
}
<?php

echo "part1: " . part1("input.txt");

print "\n";

echo "part2: " . part2("input.txt");

function part1($file_name)
{
    $file_input = fopen($file_name, "r");
    $current_max = 0;
    $sum = 0;

    while (!feof($file_input)) {
        $content = (int) fgets($file_input);

        if (!$content) {
            $current_max = max($sum, $current_max);
            $sum = 0;
        } else {
            $sum += $content;
        }
    }
    fclose($file_input);

    return $current_max;
}

function part2($file_name)
{
    $file_input = fopen($file_name, "r");
    $sum = 0;
    $calories_elves_carrying = [];

    while (!feof($file_input)) {
        $content = (int) fgets($file_input);

        if (!$content) {
            $calories_elves_carrying[] = $sum;
            $sum = 0;
        } else {
            $sum += $content;
        }
    }
    fclose($file_input);

    rsort($calories_elves_carrying);

    return $calories_elves_carrying[0] +
        $calories_elves_carrying[1] +
        $calories_elves_carrying[2];
}

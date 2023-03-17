<?php
const OPPONENT = [
    "A" => 1,
    "B" => 2,
    "C" => 3,
];

const YOU = [
    "X" => 1,
    "Y" => 2,
    "Z" => 3,
];

const RESULT = [
    // rock
    "A" => [
        // lose
        "X" => 3, // chose scissors
        // draw
        "Y" => 4, // chose rock
        // win
        "Z" => 8, // chose paper
    ],
    // paper
    "B" => [
        // lose
        "X" => 1, // chose rock
        // draw
        "Y" => 5, // chose paper
        // win
        "Z" => 9, // chose scissors
    ],
    // scissors
    "C" => [
        // lose
        "X" => 2, // chose paper
        // draw
        "Y" => 6, // chose scissors
        // win
        "Z" => 7, // chose rock
    ]
];

echo "part1: " . part1("input.txt");

print "\n";

echo "part2: " . part2("input.txt");

function part1($file_name)
{
    $file_input = fopen($file_name, "r");
    $total_score = 0;

    while (!feof($file_input)) {
        $content = fgets($file_input);
        $total_score += YOU[$content[2]];

        // draw
        if (OPPONENT[$content[0]] == YOU[$content[2]]) {
            $total_score += 3;
        } // win if you chose rock over scissors
        elseif (OPPONENT[$content[0]] > YOU[$content[2]]) {
            if (OPPONENT[$content[0]] == 3 && YOU[$content[2]] == 1) {
                $total_score += 6;
            }
        } // win if you not chose scissors and opponent not chose rock
        else {
            if (OPPONENT[$content[0]] == 1 && YOU[$content[2]] == 3) {
            } else {
                $total_score += 6;
            }
        }
    }
    fclose($file_input);

    return $total_score;
}

function part2($file_name)
{
    $file_input = fopen($file_name, "r");
    $total_score = 0;

    while (!feof($file_input)) {
        $content = fgets($file_input);

        $total_score += RESULT[$content[0]][$content[2]];

    }
    fclose($file_input);

    return $total_score;
}
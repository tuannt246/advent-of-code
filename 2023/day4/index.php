<?php

dayFour("input.txt");

function dayFour($fileName)
{
    list($first, $second) = scratchcards(readFileContents($fileName));
    printResult($first, $second);
}

function scratchcards($cards): array
{
    $points = 0;
    $cardIndex = 0;
    $count = [];
    foreach ($cards as $card) {
        $numbers = explode(': ', $card)[1];
        list($winningNumbers, $ownNumbers) = explode(' | ', $numbers);
        $matches = array_intersect(preg_split("/\s+/", $winningNumbers), preg_split("/\s+/", $ownNumbers));
        $match = count($matches);

        $cardIndex++;
        $count[$cardIndex] = ($count[$cardIndex] ?? 0) + 1;
        if ($match === 0) {
            continue;
        }

        $points += pow(2, $match - 1);
        for ($i = $cardIndex + 1; $i <= $cardIndex + $match; $i++) {
            $count[$i] = ($count[$i] ?? 0) + $count[$cardIndex];
        }
    }

    return [$points, array_sum($count)];
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function printResult($first, $second)
{
    echo "--- Day 4: Scratchcards ---" . "\n";

    echo "Cards are worth {$first} points in total." . "\n";

    echo "Total scratchcards do you end up with are {$second}." . "\n";
}





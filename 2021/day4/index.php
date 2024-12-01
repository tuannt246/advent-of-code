<?php
require 'BingoBoard.php';

dayFour("input.txt");

function dayFour($fileName)
{
    $lines = readFileContents($fileName);
    list($first, $second) = bingoBoard($lines);
    printResult($first, $second);
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function bingoBoard($dataStream): array
{
    $numbers = explode(",", array_shift($dataStream));
    $boards = [];
    $first = $second = 0;

    foreach (array_chunk($dataStream, 5) as $key => $board) {
        $boards[$key] = BingoBoard::fromArray($board);
    }
    $clonedBoards = unserialize(serialize($boards));

    foreach ($numbers as $number) {
        foreach ($boards as $board) {
            $isNumber = $board->call($number);
            if ($isNumber) {
                $first = $isNumber;
                break 2;
            }
        }

    }

    foreach ($numbers as $number) {
        foreach ($clonedBoards as $key => $board) {
            if (isset($board)) {
                $isNumber = $board->call($number);

                if ($isNumber) {
                    if (count($clonedBoards) == 1) {
                        $second = $isNumber;
                        break 2;
                    } else {
                        unset($clonedBoards[$key]);
                    }
                }
            }
        }
    }

    return [$first, $second];
}

function printResult($first, $second)
{
    echo "--- Day 4: Giant Squid ---" . "\n";

    echo "The score of the first board to win is {$first}." . "\n";

    echo "The score of the last board to win is {$second}." . "\n";
}
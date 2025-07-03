<?php

dayTwo("input.txt");

function dayTwo($fileName)
{
    $lines = readFileContents($fileName);
    list($first, $second) = reports($lines);
    printResult($first, $second);
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function reports($dataStream): array
{
    $first = $second = 0;

    foreach ($dataStream as $row) {
        $report = explode(" ", $row);
        $reportLength = count($report) - 1;
        $counter = [
            '>' => 0,
            '<' => 0,
            '=' => 0,
            'diff' => 0
        ];
        for ($i = 0; $i < $reportLength; $i++) {
            $diff = $report[$i + 1] - $report[$i];
            if ($diff > 0) {
                $counter['<']++;
                $counter['diff'] = max($diff, $counter['diff']);
            } else if ($diff < 0) {
                $counter['>']++;
                $counter['diff'] = max(abs($diff), $counter['diff']);
            } else {
                $counter['=']++;
            }
        }

        if (($counter['>'] == $reportLength && $counter['diff'] <= 3) ||
            ($counter['<'] == $reportLength && $counter['diff'] <= 3)) {
            $first++;
            $second++;
        }
    }


    return [$first, $second];
}

function printResult($first, $second)
{
    echo "--- Day 2: Red-Nosed Reports ---" . "\n";

    echo "{$first} reports are safe." . "\n";

    echo "{$second} reports, tolerating a single bad level, are safe." . "\n";

}

//
//48 46 47 49 51 54 56
//1 1 2 3 4 5
//1 2 3 4 5 5
//5 1 2 3 4 5
//1 4 3 2 1
//1 6 7 8 9
//1 2 3 4 3
//9 8 7 6 7
//7 10 8 10 11
//29 28 27 25 26 25 22 20
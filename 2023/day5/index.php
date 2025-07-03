<?php


function parseInput($input)
{
    $section = explode("\n\n", $input);

    preg_match_all('/\d+/', $section[0], $matches);
    $seeds = array_map('intval', $matches[0]);

    $maps = [];
    for ($i = 1; $i < count($section); $i++) {
        $ranges = [];
        $lines = explode("\n", $section[$i]);
        for ($j = 1; $j < count($lines); $j++) {
            $numbers = array_map('intval', explode(' ', $lines[$j]));
            $ranges[] = [
                'destination' => intval($numbers[0]),
                'source' => intval($numbers[1]),
                'range' => intval($numbers[2])
            ];
        }

        usort($ranges, function ($a, $b) {
            return $a['source'] <=> $b['source'];
        });
        $maps[] = $ranges;
    }
    return [$seeds, $maps];
}

function dayFive($fileName)
{
    list($seed, $maps) = parseInput(file_get_contents($fileName));

//    $part1 = part1($seeds, $maps);
//    $part2 = part2($seeds, $maps);
}

function part2($seeds, $maps)
{
    $seedRanges = array_chunk($seeds, 2);

    $location = [];

    foreach ($seedRanges as $seedRange) {
        $location[] = findRange($seedRange, $maps);
    }

    var_dump(min($location));
}

function findRange($seedRanges, $maps)
{
    $currentRanges = [$seedRanges];
    foreach ($maps as $map) {
        var_dump($seedRanges, $map);
        $nextRanges = [];
        $index = 0;
        while (count($currentRanges) > 0) {
            $start = $currentRanges[0][0];
            $range = $currentRanges[0][1];
            foreach ($map as $ranges) {
                if ($start >= $ranges['source'] && ($start <= $ranges['source'] + $ranges['range'])) {
                    return $seed - $ranges['source'] + $ranges['destination'];
                }
            }
        }
    }
}


function part1($seeds, $maps)
{
    $location = [];
    foreach ($seeds as $seed) {
        $location[] = findState($seed, $maps);
    }

    var_dump(min($location));
    return min($location);
}

function findState($seed, $maps)
{
    foreach ($maps as $map) {
        $seed = position($map, $seed);
    }

    return $seed;
}

function position($map, $seed)
{
    foreach ($map as $ranges) {
        if ($seed >= $ranges['source'] && ($seed <= $ranges['source'] + $ranges['range'])) {
            return $seed - $ranges['source'] + $ranges['destination'];

        }
    }
    return $seed;
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES);
}

function printResult($result)
{
    echo "--- Day 5: If You Give A Seed A Fertilizer ---" . "\n";

    echo "The lowest location number that corresponds to any of the initial seed numbers is {$result} ." . "\n";

}

if (isset($argv[1]) && $argv[1] == 's') {
    $fileName = 'sample.txt';
} else {
    $fileName = 'input.txt';
}
dayFive($fileName);
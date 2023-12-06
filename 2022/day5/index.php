<?php

echo "--- Day 5: Supply Stacks ---" . "\n";

echo "Crate ends up on top of each stack using CrateMover 9000 is " . partOne("input.txt") . "\n";

echo "Crate ends up on top of each stack using CrateMover 9001 is " . partTwo("input.txt") . "\n";

function partOne($fileName): string
{
    $lines = readFileContents($fileName);

    $stackOfCrates = createStackOfCrates($lines);

    moveCratesBetweenStacks($lines, $stackOfCrates);

    return getCratesOnTopEachStack($stackOfCrates);
}

function partTwo($fileName): string
{
    $lines = readFileContents($fileName);

    $stackOfCrates = createStackOfCrates($lines);

    moveCratesBetweenStacks($lines, $stackOfCrates, 'new');

    return getCratesOnTopEachStack($stackOfCrates);
}

function getCratesOnTopEachStack($stackOfCrates): string
{
    $result = '';

    foreach ($stackOfCrates as $crates) {
        if ($crates[0]) {
            $result .= $crates[0];
        }
    }

    return $result;
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function createStackOfCrates(&$lines): array
{
    $stackOfCrates = array();

    foreach ($lines as $lineIdx => $line) {
        unset($lines[$lineIdx]);

        if (substr($line, 1, 1) == '1') {
            break;
        }

        $crates = str_split($line, 4);

        foreach ($crates as $crateIdx => $crate) {
            $key = '' . ($crateIdx + 1);
            if (trim($crate)) {
                $stackOfCrates[$key][] = $crate[1];
            }
        }
    }

    ksort($stackOfCrates);

    return $stackOfCrates;
}

function moveCratesBetweenStacks($actions, &$stackOfCrates, $type = null)
{
    foreach ($actions as $action) {
        $direction = array();
        foreach (explode(" ", $action) as $step) {
            if (is_numeric($step)) {
                $direction[] = $step;
            }
        }

        $stackOfCrates[$direction[2]] = array_merge(getMovedCrates($stackOfCrates[$direction[1]], $direction[0], $type), $stackOfCrates[$direction[2]]);
    }
}

function getMovedCrates(&$from, $nums, $type): array
{
    $result = array_splice($from, 0, $nums);

    if ($type) {
        return $result;
    } else {
        return array_reverse($result);
    }
}
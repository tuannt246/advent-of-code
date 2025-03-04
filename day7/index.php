<?php

daySeven("input.txt");

function daySeven($fileName)
{
    $lines = readFileContents($fileName);
    $result = calculateSizeOfDirectories($lines);
    printResult($result);
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function calculateSizeOfDirectories($lines): array
{
    $currentDir = -1;
    $totalDir = 0;
    $result = [];
    foreach ($lines as $command) {
        $args = explode(" ", $command);
        if ($args[0] == "$") {
            if ($args[1] == "cd") {
                if ($args[2] == '..') {
                    $currentDir = $result[$currentDir]->parent;
                } else {
                    $obj = new \stdClass();
                    $obj->parent = $currentDir;
                    $obj->size = 0;
                    $obj->current = $args[2];

                    if ($currentDir < $totalDir) {
                        $currentDir = $totalDir;
                    }
                    $result[$currentDir] = $obj;

                    $totalDir++;
                }
            }
        } else if (is_numeric($args[0])) {
            $result[$currentDir]->size += $args[0];
        }
    }

    var_dump($result, $totalDir);
    $flip = array_reverse($result);

    $total = 0;
    foreach ($flip as $key => $dir) {
        $parent = $dir->parent;
        $size = $dir->size;

        if (isset($flip[$parent])) {
            $flip[$parent]->size += $size;
            $dir->parent = null;
//            unset($dir->parent);
        }

//        if ($dir->size <= 100000) {
//            $total += $size;
//        }
    }
    foreach ($flip as $key => $dir) {
        $parent = $dir->parent;
        $size = $dir->size;

        if (isset($flip[$parent])) {
            $flip[$parent]->size += $size;
            $dir->parent = null;
        }

//        if ($dir->size <= 100000) {
//            $total += $size;
//        }
    }

    foreach ($flip as $key => $dir) {
        $parent = $dir->parent;
        $size = $dir->size;

        if (isset($flip[$parent])) {
            $flip[$parent]->size += $size;
            $dir->parent = null;
        }

//        if ($dir->size <= 100000) {
//            $total += $size;
//        }
    }

    var_dump($total);
    return [$total];
}

function printResult($result)
{
    echo "--- Day 7: No Space Left On Device ---" . "\n";

    echo "The sum of the total sizes of those directories is {$result[0]}." . "\n";

//    echo "The number of pairs the ranges overlap is {$result[1]}." . "\n";
}
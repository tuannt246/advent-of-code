<?php
dayThree("input.txt");

function dayThree($fileName)
{
    $lines = readFileContents($fileName);
    list($factor1, $factor2) = multiplyNumbers($lines);
    printResult($factor1, $factor2);
}

function multiplyNumbers($dataStream): array
{
    $totalAll = $totalEnabled = 0;
    $action = 1; // 1 = do, 0 = don't

    foreach ($dataStream as $row) {
        $length = strlen($row);
        for ($i = 0; $i < $length; $i++) {
            if ($row[$i] == '(' && $i > 3) {
                if ($row[$i - 3] == 'm' && $row[$i - 2] == 'u' && $row[$i - 1] == 'l') {

                    $iF1 = $i + 1;
                    $factor1 = '';
                    $factor2 = '';

                    while (true) {
                        if (is_numeric($row[$iF1])) {
                            $factor1 .= $row[$iF1];
                            $iF1++;
                        } else if ($row[$iF1] == ',' && !empty($factor1)) {
                            $iF2 = $iF1 + 1;

                            while (true) {
                                if (is_numeric($row[$iF2])) {
                                    $factor2 .= $row[$iF2];
                                    $iF2++;
                                } else if ($row[$iF2] == ')' && !empty($factor2)) {
                                    $temp = (int)$factor1 * (int)$factor2;
                                    $totalAll += $temp;
                                    $totalEnabled += ($action * $temp);
                                    break 2;
                                } else {
                                    break 2;
                                }
                            }
                        } else {
                            break;
                        }
                    }
                    $i = $iF2 ?? $iF1;
                    $iF2 = null;
                }
            }

            if ($row[$i] == 'd') {
                if ($row[$i + 1] == 'o') {
                    if ($row[$i + 2] == '(' && $row[$i + 3] == ')') {
                        $i = $i + 3;
                        $action = 1;
                    } else if ($row[$i + 2] == "n" && $row[$i + 3] == "'" && $row[$i + 4] == 't'
                        && $row[$i + 5] == '(' && $row[$i + 6] == ')') {
                        $i = $i + 5;
                        $action = 0;
                    }
                }
            }
        }
    }

    return [$totalAll, $totalEnabled];
}

function readFileContents($fileName)
{
    return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function solveMulPuzzle($lines)
{
    $sum = 0;
    $state = 'SEARCH';
    $currentNum1 = '';
    $currentNum2 = '';
    $enabled = true;

    foreach ($lines as $line) {
        for ($i = 0; $i < strlen($line); $i++) {
            $char = $line[$i];

            if ($char === 'd') {
                // Check for do() or don't()
                if (substr($line, $i, 3) === 'do(') {
                    $enabled = true;
                    $i += 2;
                    continue;
                } elseif (substr($line, $i, 6) === "don't(") {
                    $enabled = false;
                    $i += 5;
                    continue;
                }
            }

            // Skip all other processing if multiplications are disabled
            if (!$enabled) continue;

            switch ($state) {
                case 'SEARCH':
                    if ($char === 'm' && substr($line, $i, 3) === 'mul') {
                        $state = 'MUL';
                        $i += 2;
                    }
                    break;

                case 'MUL':
                    if ($char === '(') {
                        $state = 'NUM1';
                        $currentNum1 = '';
                    } else {
                        $state = 'SEARCH';
                    }
                    break;

                case 'NUM1':
                    if (is_numeric($char)) {
                        $currentNum1 .= $char;
                        if (strlen($currentNum1) > 3) $state = 'SEARCH';
                    } elseif ($char === ',') {
                        $state = 'NUM2';
                        $currentNum2 = '';
                    } else {
                        $state = 'SEARCH';
                    }
                    break;

                case 'NUM2':
                    if (is_numeric($char)) {
                        $currentNum2 .= $char;
                        if (strlen($currentNum2) > 3) $state = 'SEARCH';
                    } elseif ($char === ')') {
                        if ($currentNum1 !== '' && $currentNum2 !== '') {
                            $sum += (int)$currentNum1 * (int)$currentNum2;
                        }
                        $state = 'SEARCH';
                    } else {
                        $state = 'SEARCH';
                    }
                    break;
            }
        }
    }


    return $sum;
}

function printResult($factor1, $factor2)
{
    echo "--- Day 3: Mull It Over ---" . "\n";

    echo "Adding up all of the results of the multiplications produces {$factor1}." . "\n";

    echo "Adding up all of the results of just the enabled multiplications produces {$factor2}." . "\n";
}
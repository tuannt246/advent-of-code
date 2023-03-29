<?php

function daySix($fileName)
{
    $dataStream = readFileContents($fileName);

    $result = findCompleteStartOfMarker($dataStream, 4, 14);

    printResult($result);
}

function readFileContents($fileName)
{
    return file_get_contents($fileName);
}

function findCompleteStartOfMarker($dataStream, $packet, $message): array
{
    $packetChars = 0;
    $messageChars = 0;
    $startOfPacketMarker = [];

    for ($index = 0; $index < strlen($dataStream); $index++) {
        if (in_array($dataStream[$index], $startOfPacketMarker)) {
            $key = array_search($dataStream[$index], $startOfPacketMarker);
            array_splice($startOfPacketMarker, 0, $key + 1);
        }
        $startOfPacketMarker[] = $dataStream[$index];

        // check !$packetChars to not reassign for the second time
        if (!$packetChars && count($startOfPacketMarker) == $packet) {
            $packetChars = $index + 1;
        }

        if (count($startOfPacketMarker) == $message) {
            $messageChars = $index + 1;
            break;
        }
    }

    return [$packetChars, $messageChars];
}

function printResult($result)
{
    echo "--- Day 6: Tuning Trouble ---" . "\n";

    echo "The first start-of-packet marker is complete after {$result[0]} characters have been processed." . "\n";

    echo "The first start-of-message marker is complete after {$result[1]} characters have been processed." . "\n";
}

daySix("input.txt");


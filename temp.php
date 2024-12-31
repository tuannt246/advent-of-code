<?php

function memory()
{
    $startTime = microtime(true);
    $startMemory = memory_get_usage();

    // execution code here

    $endTime = microtime(true);
    $endMemory = memory_get_usage();

    // Performance reporting
    $executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds
    $memoryUsed = $endMemory - $startMemory;
    $memoryPeak = memory_get_peak_usage();

    echo "\n--- Performance Metrics ---\n";
    echo "Execution Time: " . number_format($executionTime, 4) . " ms\n";
    echo "Memory Used: " . formatBytes($memoryUsed) . "\n";
    echo "Peak Memory Usage: " . formatBytes($memoryPeak) . "\n";
}

function formatBytes($bytes, $precision = 2): string
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}
#!/usr/bin/php
<?php

use Aternos\Thanos\Helper;
use Aternos\Thanos\World\AnvilWorld;

require_once 'vendor/autoload.php';

if (!isset($argv[1])) {
    exit("Usage: cleanup.php <world>\n");
}

$input = $argv[1];

$output = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'thanos-' . uniqid();

if (!is_dir($input) || count(scandir($input)) === 2) {
    exit('World must be a directory and not empty' . PHP_EOL);
}

if (file_exists($output) && count(scandir($output)) !== 2) {
    exit('Output directory must be empty' . PHP_EOL);
}


$startTime = microtime(true);
$world = new AnvilWorld($input, $output);
$thanos = new InPlaceThanos();
$thanos->setMinInhabitedTime(0);
$removedChunks = $thanos->snap($world);

echo sprintf('Removed %d chunks in %.2f seconds',
    $removedChunks,
    round(microtime(true) - $startTime, 2)
);
echo PHP_EOL;


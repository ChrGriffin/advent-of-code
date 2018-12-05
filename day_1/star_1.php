<?php

require_once '../helpers.php';

// load and parse frequencies from the txt file
$frequencies = loadFile(__DIR__ . '/frequencies.txt', function ($frequency) {
    return (int)$frequency;
});

$final = array_sum($frequencies);

echo "$final\n";
exit;

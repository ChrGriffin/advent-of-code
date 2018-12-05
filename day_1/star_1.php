<?php

require_once '../helpers.php';

$frequencies = loadFile(__DIR__ . '/frequencies.txt', function ($frequency) {
    return (int)$frequency;
});

$final = array_sum($frequencies);

echo "$final\n";
exit;

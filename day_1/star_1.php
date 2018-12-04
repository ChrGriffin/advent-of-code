<?php

require_once '../helpers.php';

$frequencies = loadFile(__DIR__ . '/frequencies.txt', 'int');
$final = array_sum($frequencies);

echo "$final\n";
exit;

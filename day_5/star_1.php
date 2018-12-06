<?php

require_once '../helpers.php';

// load the polymer string from the txt file
$polymer = loadFile(__DIR__ . '/polymer.txt')[0];

$regex = '/(?:';
foreach(range('a', 'z') as $letter) {
    $regex .= '(?:'
        . strtoupper($letter)
        . $letter
        . ')|(?:'
        . $letter
        . strtoupper($letter)
        . ')|';
}
$regex = rtrim($regex, '|');
$regex .= ')/';

while(preg_match($regex, $polymer)) {
    $polymer = preg_replace($regex, '', $polymer);
}

$units = strlen($polymer);

echo "$units\n";
exit;

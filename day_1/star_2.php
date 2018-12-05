<?php

ini_set('memory_limit', '512M'); // sweet jesus

require_once '../helpers.php';

function calibrate($frequencies, $current = 0, $prevFrequencies = [0])
{
    foreach($frequencies as $frequency) {
        $current += $frequency;

        if(in_array($current, $prevFrequencies)) {
            return $current;
        }

        $prevFrequencies[] = $current;
    }

    return calibrate($frequencies, $current, $prevFrequencies);
}

$frequencies = loadFile(__DIR__ . '/frequencies.txt', function ($frequency) {
    return (int)$frequency;
});

$twice = calibrate($frequencies);

echo "$twice\n";
exit;



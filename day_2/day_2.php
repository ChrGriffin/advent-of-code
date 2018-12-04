<?php

ini_set('memory_limit', '512M'); // sweet jesus

$frequencies = array_filter(
    explode("\n", file_get_contents(__DIR__ . '/frequencies.txt'))
);

function calibrate($frequencies, $current = 0, $prevFrequencies = [0])
{
    foreach($frequencies as $frequency) {
        $current += (int)$frequency;

        if(in_array($current, $prevFrequencies)) {
            return $current;
        }

        $prevFrequencies[] = $current;
    }

    return calibrate($frequencies, $current, $prevFrequencies);
}

$twice = calibrate($frequencies);

echo "$twice\n";
exit;

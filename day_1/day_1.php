<?php

$frequencies = explode("\n", file_get_contents(__DIR__ . '/frequencies.txt'));

$final = 0;
foreach($frequencies as $frequency) {
    $final += (int)$frequency;
}

echo "$final\n";
exit;

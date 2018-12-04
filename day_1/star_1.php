<?php

$frequencies = array_filter(array_map(
    function ($value) {
        return (int)$value;
    },
    explode("\n", file_get_contents(__DIR__ . '/frequencies.txt'))
));

$final = array_sum($frequencies);

echo "$final\n";
exit;

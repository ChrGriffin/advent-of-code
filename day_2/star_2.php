<?php

require_once '../helpers.php';

$boxes = loadFile(__DIR__ . '/boxes.txt');

$similarBoxes = [];
foreach($boxes as $box) {
    foreach($boxes as $innerBox) {
        if(levenshtein($box, $innerBox) === 1) {
            $similarBoxes[$box] = null;
            $similarBoxes[$innerBox] = null;
        }
    }
}

$similarBoxes = array_map(
    function ($value) {
        return str_split($value);
    },
    array_keys($similarBoxes)
);

$similarBoxes = implode(array_intersect_assoc(...$similarBoxes));

echo "$similarBoxes\n";
exit;

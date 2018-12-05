<?php

require_once '../helpers.php';

// load and parse boxes from the txt file
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

$boxChars = array_map(
    function ($value) {
        return str_split($value);
    },
    array_keys($similarBoxes)
);

$commonChars = implode(array_intersect_assoc(...$boxChars));

echo "$commonChars\n";
exit;

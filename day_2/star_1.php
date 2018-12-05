<?php

require_once '../helpers.php';

// load and parse boxes from the txt file
$boxes = loadFile(__DIR__ . '/boxes.txt');

$two = [];
$three = [];

foreach($boxes as $box) {
    $letterCount = array_count_values(str_split($box));
    foreach($letterCount as $letter => $count) {
        if($count === 2) {
            $two[$box] = null;
        }

        if($count === 3) {
            $three[$box] = null;
        }
    }
}

$sum = count($two) * count($three);
echo "$sum\n";
exit;

<?php

require_once '../helpers.php';

/**
 * Return an array of every grid coordinate used by the given patch.
 *
 * @param int $x
 * @param int $y
 * @param int $width
 * @param int $height
 * @return array
 */
function getPatchGrid(int $x, int $y, int $width, int $height)
{
    $grid = [];

    $h = 0;
    while($h < $height) {

        $w = 0;
        while($w < $width) {
            $grid[] = ($x + $w) . ':' . ($y + $h);
            $w++;
        }

        $h++;
    }

    return $grid;
}

// load and parse claims from the txt file
$claims = loadFile(__DIR__ . '/claims.txt', function ($value) {
    preg_match("/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/", $value, $matches);

    return [
        'id'     => (int)$matches[1],
        'x'      => (int)$matches[2],
        'y'      => (int)$matches[3],
        'width'  => (int)$matches[4],
        'height' => (int)$matches[5]
    ];
});

// all the code below easily be part of the loadFile callback
// but in the interest of having an obvious flow of logic
// we'll separate it out here

// count how many times each grid coordinate occurs
$gridFrequency = array_count_values(array_merge(...array_map(
    function ($claim) {
        return getPatchGrid(
            $claim['x'],
            $claim['y'],
            $claim['width'],
            $claim['height']
        );
    },
    $claims
)));

// filter the grid coordinates to ones that occur more than once and count the result
$repeats = count(array_filter($gridFrequency, function ($count) {
    return $count > 1;
}));

echo "$repeats\n";
exit;

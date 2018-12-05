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

// convert all claim parameters to a grid of coordinates
$claims = array_map(function ($claim) {
    return [
        'id' => $claim['id'],
        'grid' => getPatchGrid(
            $claim['x'],
            $claim['y'],
            $claim['width'],
            $claim['height']
        )
    ];
}, $claims);

// get a count of how often every grid coordinate occurs
$gridFrequency = array_count_values(array_merge(...array_map(function ($claim) {
    return $claim['grid'];
}, $claims)));

// filter our claims down to ones whose coordinates only occur once
$uniqueClaims = array_filter($claims, function ($claim) use ($gridFrequency) {
    foreach($claim['grid'] as $coord) {
        if($gridFrequency[$coord] > 1) {
            return false;
        }
    }

    return true;
});

// return our first unique claim
echo array_values($uniqueClaims)[0]['id'] . "\n";
exit;

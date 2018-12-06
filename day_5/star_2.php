<?php

require_once '../helpers.php';

// load the polymer string from the txt file
$polymer = loadFile(__DIR__ . '/polymer.txt')[0];

// create the regex we will use to 'react' the polymer
$reactionRegex = '/(?:';
foreach(range('a', 'z') as $letter) {
    $reactionRegex .= '(?:'
        . strtoupper($letter)
        . $letter
        . ')|(?:'
        . $letter
        . strtoupper($letter)
        . ')|';
}
$reactionRegex = rtrim($reactionRegex, '|');
$reactionRegex .= ')/';

// loop through each type of unit, remove it, then react the polymer and store the resulting length
$reactionGroups = array_fill_keys(range('a', 'z'), strlen($polymer));
foreach($reactionGroups as $letter => $value) {

    $regex = '/(?:'
        . strtoupper($letter)
        . '|'
        . $letter
        . ')/';

    $_polymer = preg_replace($regex, '', $polymer);

    while(preg_match($reactionRegex, $_polymer)) {
        $_polymer = preg_replace($reactionRegex, '', $_polymer);
    }

    $reactionGroups[$letter] = strlen($_polymer);
}

// get the shortest reacted polymer
$result = min($reactionGroups);

echo "$result\n";
exit;

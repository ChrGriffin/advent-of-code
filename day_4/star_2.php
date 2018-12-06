<?php

require_once '../helpers.php';

// we'll use these constants to refer to the three types of 'events' that can occur
CONST EVENT_FALL_ASLEEP = 1;
CONST EVENT_WAKE_UP = 2;
CONST EVENT_NEW_GUARD = 3;

// load and parse events from the txt file
// we want to transform a string into an array containing the date, event type, and any additional data
$events = loadFile(__DIR__ . '/events.txt', function ($event) {

    preg_match("/\[(.+)\] (.+)/", $event, $matches);

    switch ($matches[2]) {

        case 'wakes up':
            $eventType = EVENT_WAKE_UP;
            $data = [];
            break;

        case 'falls asleep':
            $eventType = EVENT_FALL_ASLEEP;
            $data = [];
            break;

        default:
            $eventType = EVENT_NEW_GUARD;

            preg_match("/#(\d+)/", $matches[2], $iMatches);
            $data = [
                'guard_id' => $iMatches[1]
            ];

            break;
    }

    return [
        'date' => $matches[1],
        'type' => $eventType,
        'data' => $data
    ];
});

// sort our events by date
usort($events, function ($eventA, $eventB) {
    return strtotime($eventA['date']) > strtotime($eventB['date']);
});

// loop through our events, and use the loop to determine how many minutes each guard spends asleep
$sleepLog = [];

$currentGuardId = null;
$fellAsleepAt = null;

foreach($events as $event) {

    switch($event['type']) {

        case EVENT_NEW_GUARD:
            $currentGuardId = $event['data']['guard_id'];
            $fellAsleepAt = null;

            if(!isset($sleepLog[$currentGuardId])) {
                $sleepLog[$currentGuardId] = [];
            }

            break;

        case EVENT_FALL_ASLEEP:
            $fellAsleepAt = strtotime($event['date']);
            break;

        case EVENT_WAKE_UP:
            $minutesAsleep = range(
                date('i', $fellAsleepAt),
                ((int)date('i', strtotime($event['date']))) - 1
            );

            $sleepLog[$currentGuardId] = array_merge(
                $minutesAsleep,
                $sleepLog[$currentGuardId]
            );

            $fellAsleepAt = null;
            break;
    }
}

// filter empty values first (max() throws a warning)
$sleepLog = array_filter(array_map(function ($minutes) {
    return array_count_values($minutes);
}, $sleepLog));

// refactor the arrays to contain the highest total count for any given minute
$minuteFrequency = array_map(function ($minutes) {
    return max($minutes);
}, $sleepLog);

// get the ID of the guard with the highest total count for any given minute, and that minute
$guardId = array_flip($minuteFrequency)[max($minuteFrequency)];
$minute = array_flip($sleepLog[$guardId])[max($sleepLog[$guardId])];

$result = $guardId * $minute;

echo "$result\n";
exit;

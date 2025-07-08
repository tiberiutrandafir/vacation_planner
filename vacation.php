<?php

$holidays = [
    '2025-01-01', '2025-01-02', '2025-01-06', '2025-01-07', '2025-01-24',
    '2025-04-18', '2025-04-20', '2025-04-21', '2025-05-01', '2025-06-01',
    '2025-06-08', '2025-06-09', '2025-08-15', '2025-11-30', '2025-12-01',
    '2025-12-25', '2025-12-26'
];

function allDays($year)
{
    $dates = [];
    $start = new DateTime("{$year}-01-01");
    $end = new DateTime("{$year}-12-31");
    $current = clone $start;
    while ($current <= $end) {
        $dates[] = clone $current;
        $current->modify("+1 day");
    }
    return $dates;
}

function weekendOrHoliday(DateTime $date, array $holidays)
{
    $weekday = $date->format('w');
    $fullDate = $date->format('Y-m-d');
    return ('0' === $weekday || '6' === $weekday || in_array($fullDate, $holidays));
}


function bestVacationDays(int $year, array $holidays)
{
    $dates = allDays($year);
    $dayTypes = [];
    foreach ($dates as $date) {
        $fullDate = $date->format('Y-m-d');
        $type = weekendOrHoliday($date, $holidays) ? 'free' : 'work';
        $dayTypes[] = ['date' => $fullDate, 'type' => $type];
    }

    $proposedDays = [];
    $allDays = count($dayTypes);
    for ($i = 0; $i < $allDays; $i++) {
        // isset | array key exist | $dayTypes[$i]['type'] ?? 0
        if (isset($dayTypes[$i]) && array_key_exists('type', $dayTypes[$i])) {
            if ($dayTypes[$i]['type'] !== 'work') continue;
            $score = 0;
            if ($i > 0 && $dayTypes[$i - 1]['type'] === 'free') $score++;
            if ($i < $allDays - 1 && $dayTypes[$i + 1]['type'] === 'free') $score++;
            if ($i > 0 && in_array($dayTypes[$i - 1]['date'], $holidays) || $i < $allDays - 1 && in_array($dayTypes[$i + 1]['date'], $holidays)) $score++;
            $proposedDays[] = ['score' => $score, 'date' => $dayTypes[$i]['date']];
        }
    }
    usort($proposedDays, fn($a, $b) => $b['score'] <=> $a['score']);
}

bestVacationDays(2025, $holidays);

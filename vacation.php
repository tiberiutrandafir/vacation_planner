<?php

$holidays = [
    '2025-01-01', '2025-01-02', '2025-01-06', '2025-01-07', '2025-01-24',
    '2025-04-18', '2025-04-20', '2025-04-21', '2025-05-01', '2025-06-01',
    '2025-06-08', '2025-06-09', '2025-08-15', '2025-11-30', '2025-12-01',
    '2025-12-25', '2025-12-26'
];

function allDays ($year) {
    $dates = [];
    $start = new DateTime("{$year}-01-01");
    $end = new DateTime("{$year}-12-31");
    $current = clone $start;
    while($current <= $end) {
        $dates[] = clone $current;
        $current->modify("+1 day");
    }
//    echo "<pre>";
//    print_r($dates);
//    echo"</pre>";
    return $dates;
}

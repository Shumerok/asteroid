<?php

$dateNow = date('Y-m-d');
$dateBefore = date('Y-m-d', strtotime('-3 day'));

return [
    'api_key' => env('ASTEROID_API_KEY'),
    'date_now' => env('ASTEROID_NOW_DATE', $dateNow),
    'date_before' => env('ASTEROID_DAYS_BEFORE', $dateBefore),
];


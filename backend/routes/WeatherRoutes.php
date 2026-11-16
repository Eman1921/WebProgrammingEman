<?php

Flight::route('GET /weather/forecast', function () {
    $query = Flight::request()->query;
    $city = $query['city'] ?? '';
    $days = $query['days'] ?? 7;
    Flight::json(Flight::weather_service()->get_forecast((string) $city, $days));
});

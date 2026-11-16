<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/HttpException.php';
require_once __DIR__ . '/Validator.php';

class WeatherService
{
    private const UNAVAILABLE = 'The weather service is not available at the moment. Please try again later.';

    public function get_forecast(string $city, string|int $days = 7): array
    {
        $city = trim($city);
        Validator::string(['city' => $city], 'city', 2, 50);
        $days = Validator::integer(['days' => $days], 'days', 1, 16);

        $locationUrl = Config::OPEN_METEO_GEOCODING_URL() . '?' . http_build_query([
            'name' => $city,
            'count' => 1,
            'language' => 'en',
            'format' => 'json'
        ]);
        $locationData = $this->request($locationUrl);
        $location = $locationData['results'][0] ?? null;
        if (!is_array($location) || !isset($location['latitude'], $location['longitude'])) {
            throw new NotFoundException("No city called '{$city}' was found.");
        }

        $forecastUrl = Config::OPEN_METEO_FORECAST_URL() . '?' . http_build_query([
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
            'daily' => 'weather_code,temperature_2m_max,temperature_2m_min',
            'forecast_days' => $days,
            'timezone' => 'auto'
        ]);
        $forecast = $this->request($forecastUrl);
        $daily = $forecast['daily'] ?? null;
        if (!is_array($daily)
            || !isset($daily['time'], $daily['weather_code'], $daily['temperature_2m_max'], $daily['temperature_2m_min'])
            || !is_array($daily['time'])
            || !is_array($daily['weather_code'])
            || !is_array($daily['temperature_2m_max'])
            || !is_array($daily['temperature_2m_min'])) {
            error_log('Open-Meteo returned an unexpected forecast response.');
            throw new ExternalServiceException(self::UNAVAILABLE);
        }

        $daysList = [];
        foreach ($daily['time'] as $index => $date) {
            if (!isset($daily['weather_code'][$index], $daily['temperature_2m_max'][$index], $daily['temperature_2m_min'][$index])) {
                error_log('Open-Meteo returned incomplete daily forecast data.');
                throw new ExternalServiceException(self::UNAVAILABLE);
            }

            $weatherCode = (int) $daily['weather_code'][$index];
            $daysList[] = [
                'date' => (string) $date,
                'description' => $weatherCode === 61 ? 'Light rain' : 'Forecast available',
                'icon' => $weatherCode === 61 ? 'cloud-rain' : 'cloud',
                'weather_code' => $weatherCode,
                'temperature_max_c' => (float) $daily['temperature_2m_max'][$index],
                'temperature_min_c' => (float) $daily['temperature_2m_min'][$index]
            ];
        }

        return [
            'city' => (string) $location['name'],
            'country' => (string) ($location['country'] ?? ''),
            'days' => $daysList
        ];
    }

    private function request(string $url): array
    {
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_TIMEOUT => max(1, Config::OPEN_METEO_TIMEOUT()),
            CURLOPT_HTTPHEADER => ['Accept: application/json']
        ]);

        $body = curl_exec($curl);
        $status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);

        if ($body === false) {
            error_log('Open-Meteo request failed: ' . $error);
            throw new ExternalServiceException(self::UNAVAILABLE);
        }
        if ($status !== 200) {
            error_log('Open-Meteo returned HTTP status ' . $status . '.');
            throw new ExternalServiceException(self::UNAVAILABLE);
        }

        $data = json_decode($body, true);
        if (!is_array($data)) {
            error_log('Open-Meteo returned invalid JSON.');
            throw new ExternalServiceException(self::UNAVAILABLE);
        }

        return $data;
    }
}

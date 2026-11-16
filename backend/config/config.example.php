<?php

class Config
{
    public static function DB_HOST(): string
    {
        return self::get_env('DB_HOST', '127.0.0.1');
    }

    public static function DB_NAME(): string
    {
        return self::get_env('DB_NAME', 'grbzem');
    }

    public static function DB_USER(): string
    {
        return self::get_env('DB_USER', 'root');
    }

    public static function DB_PASSWORD(): string
    {
        return self::get_env('DB_PASSWORD', '');
    }

    public static function OPEN_METEO_GEOCODING_URL(): string
    {
        return self::get_env('OPEN_METEO_GEOCODING_URL', 'https://geocoding-api.open-meteo.com/v1/search');
    }

    public static function OPEN_METEO_FORECAST_URL(): string
    {
        return self::get_env('OPEN_METEO_FORECAST_URL', 'https://api.open-meteo.com/v1/forecast');
    }

    public static function OPEN_METEO_TIMEOUT(): int
    {
        return (int) self::get_env('OPEN_METEO_TIMEOUT', '5');
    }

    private static function get_env(string $name, string $default): string
    {
        $value = getenv($name);
        return $value === false ? $default : $value;
    }
}

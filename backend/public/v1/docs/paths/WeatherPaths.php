<?php

use OpenApi\Attributes as OA;

class WeatherPaths
{
    #[OA\Get(path: '/weather/forecast', tags: ['weather'], summary: 'Get a city weather forecast', parameters: [
        new OA\Parameter(name: 'city', in: 'query', required: true, description: 'City name', example: 'Sarajevo', schema: new OA\Schema(type: 'string', minLength: 2, maxLength: 50)),
        new OA\Parameter(name: 'days', in: 'query', required: false, description: 'Number of forecast days, from 1 to 16; default is 7', example: 7, schema: new OA\Schema(type: 'integer', minimum: 1, maximum: 16))
    ], responses: [
        new OA\Response(response: 200, description: 'Forecast for the city', content: new OA\JsonContent(ref: '#/components/schemas/Forecast')),
        new OA\Response(response: 400, description: 'City name or days value is invalid', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        new OA\Response(response: 404, description: 'City was not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        new OA\Response(response: 503, description: 'Weather service is unavailable', content: new OA\JsonContent(ref: '#/components/schemas/Error'))
    ])]
    public function getWeatherForecast() {}
}

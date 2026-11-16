<?php

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'GrbZem API',
    description: 'REST API for the GrbZem Premier League kit shop.',
    version: '1.0.0'
)]
#[OA\Server(url: API_BASE_URL, description: 'Current GrbZem API server')]
#[OA\Schema(schema: 'Error', required: ['status', 'error'], properties: [
    new OA\Property(property: 'status', type: 'integer', example: 400),
    new OA\Property(property: 'error', type: 'string', example: "Field 'name' is required.")
])]
#[OA\Schema(schema: 'Message', required: ['message'], properties: [
    new OA\Property(property: 'message', type: 'string', example: 'Kit deleted.')
])]
#[OA\Schema(schema: 'UserInput', required: ['first_name', 'last_name', 'email', 'password_hash', 'role'], properties: [
    new OA\Property(property: 'first_name', type: 'string', example: 'Alex'),
    new OA\Property(property: 'last_name', type: 'string', example: 'Morgan'),
    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'alex@example.com'),
    new OA\Property(property: 'password_hash', type: 'string', example: '$2y$...'),
    new OA\Property(property: 'role', type: 'string', enum: ['customer', 'admin'], example: 'customer')
])]
#[OA\Schema(schema: 'User', allOf: [new OA\Schema(ref: '#/components/schemas/UserInput')], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'created_at', type: 'string', format: 'date-time')
])]
#[OA\Schema(schema: 'CategoryInput', required: ['name'], properties: [
    new OA\Property(property: 'name', type: 'string', example: 'Premier League Home Shirts'),
    new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Home shirts from Premier League clubs.')
])]
#[OA\Schema(schema: 'Category', allOf: [new OA\Schema(ref: '#/components/schemas/CategoryInput')], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1)
])]
#[OA\Schema(schema: 'KitInput', required: ['category_id', 'team_name', 'season', 'kit_type', 'name', 'size', 'price', 'stock_quantity', 'image_path'], properties: [
    new OA\Property(property: 'category_id', type: 'integer', example: 1),
    new OA\Property(property: 'team_name', type: 'string', example: 'Manchester City'),
    new OA\Property(property: 'season', type: 'string', example: '2026/27'),
    new OA\Property(property: 'kit_type', type: 'string', example: 'home'),
    new OA\Property(property: 'name', type: 'string', example: 'Home Shirt'),
    new OA\Property(property: 'description', type: 'string', nullable: true),
    new OA\Property(property: 'size', type: 'string', example: 'M'),
    new OA\Property(property: 'price', type: 'number', format: 'float', example: 84.00),
    new OA\Property(property: 'stock_quantity', type: 'integer', example: 12),
    new OA\Property(property: 'image_path', type: 'string', example: 'frontend/assets/images/man-city-home.png')
])]
#[OA\Schema(schema: 'Kit', allOf: [new OA\Schema(ref: '#/components/schemas/KitInput')], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1)
])]
#[OA\Schema(schema: 'OrderInput', required: ['user_id', 'total_amount'], properties: [
    new OA\Property(property: 'user_id', type: 'integer', example: 1),
    new OA\Property(property: 'status', type: 'string', enum: ['pending', 'paid', 'shipped', 'delivered', 'cancelled'], example: 'pending'),
    new OA\Property(property: 'total_amount', type: 'number', format: 'float', example: 84.00)
])]
#[OA\Schema(schema: 'Order', allOf: [new OA\Schema(ref: '#/components/schemas/OrderInput')], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'created_at', type: 'string', format: 'date-time')
])]
#[OA\Schema(schema: 'OrderItemInput', required: ['order_id', 'kit_id', 'quantity', 'unit_price'], properties: [
    new OA\Property(property: 'order_id', type: 'integer', example: 1),
    new OA\Property(property: 'kit_id', type: 'integer', example: 1),
    new OA\Property(property: 'quantity', type: 'integer', example: 1),
    new OA\Property(property: 'unit_price', type: 'number', format: 'float', example: 84.00)
])]
#[OA\Schema(schema: 'OrderItem', allOf: [new OA\Schema(ref: '#/components/schemas/OrderItemInput')], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1)
])]
#[OA\Schema(schema: 'ReviewInput', required: ['user_id', 'kit_id', 'rating'], properties: [
    new OA\Property(property: 'user_id', type: 'integer', example: 1),
    new OA\Property(property: 'kit_id', type: 'integer', example: 1),
    new OA\Property(property: 'rating', type: 'integer', minimum: 1, maximum: 5, example: 5),
    new OA\Property(property: 'comment', type: 'string', nullable: true, example: 'Good fit and comfortable fabric.')
])]
#[OA\Schema(schema: 'Review', allOf: [new OA\Schema(ref: '#/components/schemas/ReviewInput')], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'created_at', type: 'string', format: 'date-time')
])]
#[OA\Schema(schema: 'ForecastDay', required: ['date', 'description', 'icon', 'weather_code', 'temperature_max_c', 'temperature_min_c'], properties: [
    new OA\Property(property: 'date', type: 'string', format: 'date', example: '2026-11-17'),
    new OA\Property(property: 'description', type: 'string', example: 'Light rain'),
    new OA\Property(property: 'icon', type: 'string', example: 'cloud-rain'),
    new OA\Property(property: 'weather_code', type: 'integer', example: 61),
    new OA\Property(property: 'temperature_max_c', type: 'number', format: 'float', example: 12.4),
    new OA\Property(property: 'temperature_min_c', type: 'number', format: 'float', example: 7.1)
])]
#[OA\Schema(schema: 'Forecast', required: ['city', 'country', 'days'], properties: [
    new OA\Property(property: 'city', type: 'string', example: 'Sarajevo'),
    new OA\Property(property: 'country', type: 'string', example: 'Bosnia and Herzegovina'),
    new OA\Property(property: 'days', type: 'array', items: new OA\Items(ref: '#/components/schemas/ForecastDay'))
])]
class OpenApiSpec {}

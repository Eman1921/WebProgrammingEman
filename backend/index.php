<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/services/HttpException.php';
require_once __DIR__ . '/services/Validator.php';
require_once __DIR__ . '/services/BaseService.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/CategoryService.php';
require_once __DIR__ . '/services/KitService.php';
require_once __DIR__ . '/services/OrderService.php';
require_once __DIR__ . '/services/OrderItemService.php';
require_once __DIR__ . '/services/ReviewService.php';
require_once __DIR__ . '/services/WeatherService.php';

Flight::register('user_service', 'UserService');
Flight::register('category_service', 'CategoryService');
Flight::register('kit_service', 'KitService');
Flight::register('order_service', 'OrderService');
Flight::register('order_item_service', 'OrderItemService');
Flight::register('review_service', 'ReviewService');
Flight::register('weather_service', 'WeatherService');

Flight::map('error', function (Throwable $error) {
    if ($error instanceof HttpException) {
        $status = $error->get_status();
        $message = $error->getMessage();
    } else {
        $status = 500;
        $message = 'Something went wrong on the server. Please try again later.';
        error_log($error);
    }

    Flight::response()
        ->clearBody()
        ->status($status)
        ->header('Content-Type', 'application/json')
        ->write(json_encode(['status' => $status, 'error' => $message]))
        ->send();
});

Flight::map('notFound', function () {
    $request = Flight::request();
    $url = strtok($request->url, '?');
    $message = 'Endpoint ' . $request->method . ' ' . $url . ' does not exist.';

    Flight::response()
        ->clearBody()
        ->status(404)
        ->header('Content-Type', 'application/json')
        ->write(json_encode(['status' => 404, 'error' => $message]))
        ->send();
});

Flight::route('GET /', function () {
    Flight::json(['app' => 'GrbZem API', 'message' => 'The backend is running.']);
});

require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/CategoryRoutes.php';
require_once __DIR__ . '/routes/KitRoutes.php';
require_once __DIR__ . '/routes/OrderRoutes.php';
require_once __DIR__ . '/routes/OrderItemRoutes.php';
require_once __DIR__ . '/routes/ReviewRoutes.php';
require_once __DIR__ . '/routes/WeatherRoutes.php';

Flight::start();

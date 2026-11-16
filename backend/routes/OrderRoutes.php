<?php

Flight::route('GET /orders', function () {
    Flight::json(Flight::order_service()->get_all());
});

Flight::route('GET /orders/@id:[0-9]+', function ($id) {
    Flight::json(Flight::order_service()->get_by_id((int) $id));
});

Flight::route('POST /orders', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::order_service()->add($data), 201);
});

Flight::route('PUT /orders/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::order_service()->update($data, (int) $id));
});

Flight::route('DELETE /orders/@id:[0-9]+', function ($id) {
    Flight::order_service()->delete((int) $id);
    Flight::json(['message' => 'Order deleted.']);
});

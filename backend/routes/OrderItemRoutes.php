<?php

Flight::route('GET /order-items', function () {
    Flight::json(Flight::order_item_service()->get_all());
});

Flight::route('GET /order-items/@id:[0-9]+', function ($id) {
    Flight::json(Flight::order_item_service()->get_by_id((int) $id));
});

Flight::route('POST /order-items', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::order_item_service()->add($data), 201);
});

Flight::route('PUT /order-items/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::order_item_service()->update($data, (int) $id));
});

Flight::route('DELETE /order-items/@id:[0-9]+', function ($id) {
    Flight::order_item_service()->delete((int) $id);
    Flight::json(['message' => 'Order item deleted.']);
});

<?php

Flight::route('GET /categories', function () {
    Flight::json(Flight::category_service()->get_all());
});

Flight::route('GET /categories/@id:[0-9]+', function ($id) {
    Flight::json(Flight::category_service()->get_by_id((int) $id));
});

Flight::route('POST /categories', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::category_service()->add($data), 201);
});

Flight::route('PUT /categories/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::category_service()->update($data, (int) $id));
});

Flight::route('DELETE /categories/@id:[0-9]+', function ($id) {
    Flight::category_service()->delete((int) $id);
    Flight::json(['message' => 'Category deleted.']);
});

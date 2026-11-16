<?php

Flight::route('GET /kits', function () {
    Flight::json(Flight::kit_service()->get_all());
});

Flight::route('GET /kits/@id:[0-9]+', function ($id) {
    Flight::json(Flight::kit_service()->get_by_id((int) $id));
});

Flight::route('POST /kits', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::kit_service()->add($data), 201);
});

Flight::route('PUT /kits/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::kit_service()->update($data, (int) $id));
});

Flight::route('DELETE /kits/@id:[0-9]+', function ($id) {
    Flight::kit_service()->delete((int) $id);
    Flight::json(['message' => 'Kit deleted.']);
});

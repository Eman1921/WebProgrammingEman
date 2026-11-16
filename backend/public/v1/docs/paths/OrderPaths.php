<?php

use OpenApi\Attributes as OA;

class OrderPaths
{
    #[OA\Get(path: '/orders', tags: ['orders'], summary: 'List orders', responses: [new OA\Response(response: 200, description: 'Order list', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Order'))), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function getOrders() {}

    #[OA\Get(path: '/orders/{id}', tags: ['orders'], summary: 'Get one order', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Order', content: new OA\JsonContent(ref: '#/components/schemas/Order')), new OA\Response(response: 404, description: 'Order not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function getOrdersById() {}

    #[OA\Post(path: '/orders', tags: ['orders'], summary: 'Create an order', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/OrderInput')), responses: [new OA\Response(response: 201, description: 'Created order', content: new OA\JsonContent(ref: '#/components/schemas/Order')), new OA\Response(response: 400, description: 'Invalid order data or user', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function postOrders() {}

    #[OA\Put(path: '/orders/{id}', tags: ['orders'], summary: 'Update an order', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/OrderInput')), responses: [new OA\Response(response: 200, description: 'Updated order', content: new OA\JsonContent(ref: '#/components/schemas/Order')), new OA\Response(response: 400, description: 'Invalid order data or user', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Order not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function putOrdersById() {}

    #[OA\Delete(path: '/orders/{id}', tags: ['orders'], summary: 'Delete an order', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Order deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 400, description: 'Order still has order items', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Order not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function deleteOrdersById() {}
}

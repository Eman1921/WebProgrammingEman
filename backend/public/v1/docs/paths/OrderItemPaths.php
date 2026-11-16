<?php

use OpenApi\Attributes as OA;

class OrderItemPaths
{
    #[OA\Get(path: '/order-items', tags: ['order items'], summary: 'List order items', responses: [new OA\Response(response: 200, description: 'Order item list', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/OrderItem'))), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function getOrderItems() {}

    #[OA\Get(path: '/order-items/{id}', tags: ['order items'], summary: 'Get one order item', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Order item', content: new OA\JsonContent(ref: '#/components/schemas/OrderItem')), new OA\Response(response: 404, description: 'Order item not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function getOrderItemsById() {}

    #[OA\Post(path: '/order-items', tags: ['order items'], summary: 'Create an order item', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/OrderItemInput')), responses: [new OA\Response(response: 201, description: 'Created order item', content: new OA\JsonContent(ref: '#/components/schemas/OrderItem')), new OA\Response(response: 400, description: 'Invalid order item, order or kit', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function postOrderItems() {}

    #[OA\Put(path: '/order-items/{id}', tags: ['order items'], summary: 'Update an order item', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/OrderItemInput')), responses: [new OA\Response(response: 200, description: 'Updated order item', content: new OA\JsonContent(ref: '#/components/schemas/OrderItem')), new OA\Response(response: 400, description: 'Invalid order item, order or kit', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Order item not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function putOrderItemsById() {}

    #[OA\Delete(path: '/order-items/{id}', tags: ['order items'], summary: 'Delete an order item', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Order item deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 404, description: 'Order item not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function deleteOrderItemsById() {}
}

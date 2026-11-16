<?php

use OpenApi\Attributes as OA;

class KitPaths
{
    #[OA\Get(path: '/kits', tags: ['kits'], summary: 'List kits', responses: [new OA\Response(response: 200, description: 'Kit list', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Kit'))), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function getKits() {}

    #[OA\Get(path: '/kits/{id}', tags: ['kits'], summary: 'Get one kit', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Kit', content: new OA\JsonContent(ref: '#/components/schemas/Kit')), new OA\Response(response: 404, description: 'Kit not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function getKitsById() {}

    #[OA\Post(path: '/kits', tags: ['kits'], summary: 'Create a kit', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/KitInput')), responses: [new OA\Response(response: 201, description: 'Created kit', content: new OA\JsonContent(ref: '#/components/schemas/Kit')), new OA\Response(response: 400, description: 'Invalid kit data or category', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function postKits() {}

    #[OA\Put(path: '/kits/{id}', tags: ['kits'], summary: 'Update a kit', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/KitInput')), responses: [new OA\Response(response: 200, description: 'Updated kit', content: new OA\JsonContent(ref: '#/components/schemas/Kit')), new OA\Response(response: 400, description: 'Invalid kit data or category', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Kit not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function putKitsById() {}

    #[OA\Delete(path: '/kits/{id}', tags: ['kits'], summary: 'Delete a kit', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Kit deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 400, description: 'Kit still has order items or reviews', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Kit not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function deleteKitsById() {}
}

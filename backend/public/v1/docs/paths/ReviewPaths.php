<?php

use OpenApi\Attributes as OA;

class ReviewPaths
{
    #[OA\Get(path: '/reviews', tags: ['reviews'], summary: 'List reviews', responses: [new OA\Response(response: 200, description: 'Review list', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Review'))), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function getReviews() {}

    #[OA\Get(path: '/reviews/{id}', tags: ['reviews'], summary: 'Get one review', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Review', content: new OA\JsonContent(ref: '#/components/schemas/Review')), new OA\Response(response: 404, description: 'Review not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function getReviewsById() {}

    #[OA\Post(path: '/reviews', tags: ['reviews'], summary: 'Create a review', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ReviewInput')), responses: [new OA\Response(response: 201, description: 'Created review', content: new OA\JsonContent(ref: '#/components/schemas/Review')), new OA\Response(response: 400, description: 'Invalid review, user or kit', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function postReviews() {}

    #[OA\Put(path: '/reviews/{id}', tags: ['reviews'], summary: 'Update a review', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ReviewInput')), responses: [new OA\Response(response: 200, description: 'Updated review', content: new OA\JsonContent(ref: '#/components/schemas/Review')), new OA\Response(response: 400, description: 'Invalid review, user or kit', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Review not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function putReviewsById() {}

    #[OA\Delete(path: '/reviews/{id}', tags: ['reviews'], summary: 'Delete a review', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Review deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 404, description: 'Review not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 500, description: 'Server error', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function deleteReviewsById() {}
}

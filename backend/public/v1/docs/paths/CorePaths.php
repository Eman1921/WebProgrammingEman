<?php

use OpenApi\Attributes as OA;

class CorePaths
{
    #[OA\Get(path: '/', tags: ['general'], summary: 'Check that the backend is running', responses: [
        new OA\Response(response: 200, description: 'The backend is running')
    ])]
    public function getRoot() {}
}

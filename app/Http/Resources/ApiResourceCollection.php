<?php

namespace App\Http\Resources;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResourceCollection extends ResourceCollection
{
    public function with($request)
    {
        return ['status' => 'success'];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);

        if (isset($jsonResponse['meta']['links']))
            unset($jsonResponse['meta']['links']);

        $response->setContent(json_encode($jsonResponse));

        return $response->setStatusCode(Response::HTTP_OK)
            ->header('Content-Type', 'application/json');
    }
}

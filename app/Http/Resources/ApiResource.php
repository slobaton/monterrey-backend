<?php

namespace App\Http\Resources;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    private $statusCode;

    public function __construct($resource, $code = Response::HTTP_OK)
    {
        parent::__construct($resource);
        $this->statusCode = $code;
    }

    public function with($request)
    {
        return ['status' => 'success'];
    }

    public function withResponse($request, $response): JsonResponse
    {
        return $response
            ->setStatusCode($this->statusCode)
            ->header('Content-Type', 'application/json');
    }
}

<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\UserResource;

class RoleCollection extends ApiResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
                ->map(function ($role) {
                    return new RoleResource($role);
                })
        ];
    }
}

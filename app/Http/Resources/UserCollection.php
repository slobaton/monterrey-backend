<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\UserResource;

class UserCollection extends ApiResourceCollection
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
                ->map(function ($user) {
                    return new UserResource($user);
                })
        ];
    }
}

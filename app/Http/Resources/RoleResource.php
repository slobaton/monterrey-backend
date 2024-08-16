<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiResource;

class RoleResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id'               => $this->id,
            'name'             => $this->name,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at
        ];

        return $data;
    }
}

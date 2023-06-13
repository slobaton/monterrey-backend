<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiResource;

class UserResource extends ApiResource
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
            'username'         => $this->username,
            'paternal_surname' => $this->paternal_surname,
            'maternal_surname' => $this->maternal_surname,
            'email'            => $this->email,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at
        ];

        return $data;
    }
}

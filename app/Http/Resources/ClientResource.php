<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ClientResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     * @return array
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'               => $this->id,
            'nit'              => $this->nit,
            'name'             => $this->name,
            'paternal_surname' => $this->paternal_surname,
            'maternal_surname' => $this->maternal_surname,
            'phone'            => $this->phone,
            'cellphone'        => $this->cellphone,
            'address'          => $this->address,
            'observations'     => $this->observations,
            'is_active'        => $this->is_active,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at
        ];

        return $data;
    }
}

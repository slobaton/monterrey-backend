<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class SystemParameterResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'               => $this->id,
            'code'             => $this->code,
            'name'             => $this->name,
            'value'            => $this->value,
            'description'      => $this->description,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at
        ];

        return $data;
    }
}

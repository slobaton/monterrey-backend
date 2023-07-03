<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ClothSizeResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'description'           => $this->description,
            'wash_price'            => $this->wash_price,
            'wash_special_price'    => $this->wash_special_price,
            'is_active'             => $this->is_active,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at
        ];

        return $data;
    }
}

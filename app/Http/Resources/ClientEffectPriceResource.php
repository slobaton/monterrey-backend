<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ClientEffectPriceResource extends ApiResource
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
            'name'             => $this->name,
            'price'            => $this->price,
            'description'      => $this->description,
            'is_active'        => $this->is_active,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
            'effect_price'  => $this->pivot
        ];

        return $data;
    }
}

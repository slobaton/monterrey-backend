<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class WashOrderDetailResource extends ApiResource
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
            'id'                     => $this->id,
            'wash_order_id'          => $this->wash_order_id,
            'cloth_type_id'          => $this->cloth_type_id,
            'cloth_size_id'          => $this->cloth_size_id,
            'is_special_wash'        => $this->is_special_wash,
            'wash_price'             => $this->wash_price,
            'effect_price'           => $this->effect_price,
            'num_buttonholes'        => $this->num_buttonholes,
            'additional_price'       => $this->additional_price,
            'additional_price_desc'  => $this->additional_price_desc,
            'unit_price'             => $this->unit_price,
            'quantity'               => $this->quantity,
            'sub_total_price'        => $this->sub_total_price,
            'observations'           => $this->observations,
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at
        ];

        $clothType = new ClothTypeResource($this->whenLoaded('clothType'));
        if (!is_null($clothType)) {
            $data['cloth_type'] = $clothType;
        }

        $clothSize = new ClothSizeResource($this->whenLoaded('clothSize'));
        if (!is_null($clothSize)) {
            $data['cloth_size'] = $clothSize;
        }

        return $data;
    }
}

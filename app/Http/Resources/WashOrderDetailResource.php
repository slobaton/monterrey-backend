<?php

namespace App\Http\Resources;

use App\Enums\Roles;
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
        $isReceptionist = $request->user()?->hasAnyRole([Roles::RECEPTIONIST->value]);

        $data = [
            'id'                     => $this->id,
            'wash_order_id'          => $this->wash_order_id,
            'cloth_type_id'          => $this->cloth_type_id,
            'cloth_size_id'          => $this->cloth_size_id,
            'is_focalizado_active'   => $this->is_focalizado_active,
            'is_nevado_active'       => $this->is_nevado_active,
            'num_buttonholes'        => $this->num_buttonholes,
            'quantity'               => $this->quantity,
            'observations'           => $this->observations,
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at
        ];

        if (!$isReceptionist) {
            $data['wash_price']        = $this->wash_price;
            $data['effect_price']      = $this->effect_price;
            $data['focalizado_price']  = $this->focalizado_price;
            $data['nevado_price']      = $this->nevado_price;
            $data['buttonholes_price'] = $this->buttonholes_price;
            $data['unit_price']        = $this->unit_price;
            $data['subtotal_price']    = $this->subtotal_price;
        }

        $clothType = new ClothTypeResource($this->whenLoaded('clothType'));
        if (!is_null($clothType)) {
            $data['cloth_type'] = $clothType;
        }

        $clothSize = new ClothSizeResource($this->whenLoaded('clothSize'));
        if (!is_null($clothSize)) {
            $data['cloth_size'] = $clothSize;
        }

        $effects = EffectResource::collection($this->whenLoaded('effects'));

        if (!is_null($effects)) {
            $data['effects'] = $effects;
        }

        return $data;
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class WashOrderResource extends ApiResource
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
            'id'                 => $this->id,
            'client_id'          => $this->client_id,
            'wash_type_id'       => $this->wash_type_id,
            'code'               => $this->code,
            'date'               => $this->date,
            'total_quantity'     => $this->total_quantity,
            'total_price'        => $this->total_price,
            'status'             => $this->status,
            'deliver_quantity'   => $this->deliver_quantity,
            'observations'       => $this->observations,
            'is_special_price'   => $this->is_special_price,
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at
        ];

        $client = new ClientResource($this->whenLoaded('client'));
        if (!is_null($client)) {
            $data['client'] = $client;
        }

        $washType = new WashTypeResource($this->whenLoaded('washType'));
        if (!is_null($washType)) {
            $data['wash_type'] = $washType;
        }

        $details = WashOrderDetailResource::collection($this->whenLoaded('details'));
        if (!is_null($details)) {
            $data['details'] = $details;
        }

        return $data;
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class IncomeReceiptResource extends ApiResource
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
            'date'             => $this->date,
            'status'           => $this->status,
            'canceled_reason'  => $this->canceled_reason,
            'user_id'          => $this->user_id,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at
        ];

        return $data;
    }
}

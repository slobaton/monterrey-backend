<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ClothSizeCollection extends ApiResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection
                ->map(function ($clothSize) {
                    return new ClothSizeResource($clothSize);
                })
        ];
    }
}

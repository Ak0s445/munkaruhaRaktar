<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'size' => $this->size,
            'category' => $this->category?->makeHidden('id', 'created_at', 'updated_at'),
            'location' => $this->location?->makeHidden('id', 'created_at', 'updated_at'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

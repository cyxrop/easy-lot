<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LotResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'product' => new UserResource($this->whenLoaded('product')),
            'price' => $this->price,
            'meta' => $this->meta->toArray(),
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

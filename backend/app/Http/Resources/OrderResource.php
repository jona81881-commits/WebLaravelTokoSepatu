<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->order_id,
            'order_code' => $this->order_code,
            'customer_name' => $this->customer_name,
            'address' => $this->address,
            'phone' => $this->phone,
            'quantity' => $this->quantity,
            'total_price' => (float) $this->total_price,
            'status' => $this->status,
            'product' => new ProductResource($this->whenLoaded('product')),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

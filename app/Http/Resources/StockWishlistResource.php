<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockWishlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'order_data' => $this->order_data,
            'user_id' => $this->user_id,
            'quantity' => $this->quantity,
            'product' => $this->product,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

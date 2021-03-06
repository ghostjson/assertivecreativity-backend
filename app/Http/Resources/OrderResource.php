<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'buyer_id' => $this->buyer_id,
            'seller_id' => $this->seller_id,
            'product_id' => $this->product_id,
            'data' => json_decode($this->data),
            'delivery_date' => json_decode($this->delivery_date),
            'order_status' => $this->order_status,
            'payment_id' => $this->payment_id,
            'created_at' => $this->created_at
        ];
    }
}

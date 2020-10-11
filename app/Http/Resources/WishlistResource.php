<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed product_id
 * @property mixed user_id
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed quantity
 * @property mixed product
 * @property mixed custom_forms
 */
class WishlistResource extends JsonResource
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
            'custom_forms_entry' => $this->custom_forms,
            'user_id' => $this->user_id,
            'quantity' => $this->quantity,
            'product' => $this->product,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

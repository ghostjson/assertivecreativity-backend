<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed basePrice
 * @property mixed description
 * @property mixed image
 * @property mixed priceTable
 * @property mixed priceTableMode
 * @property mixed sales
 * @property mixed serial
 * @property mixed customForms
 * @property mixed category
 * @property mixed seller_id
 * @property mixed created_at
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
          'id' => $this->id,
          'name' => $this->name,
          'base_price' => $this->base_price,
          'description' => $this->description,
          'image' => $this->image,
          'price_table' => $this->price_table,
          'price_table_mode' => $this->price_table_mode,
          'sales' => $this->sales,
          'serial' => $this->serial,
          'custom_forms'=> $this->custom_forms,
          'category' => $this->category,
          'seller_id' => $this->seller_id,
          'created_at' => $this->created_at
        ];
    }
}

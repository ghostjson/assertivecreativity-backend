<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed email
 * @property mixed role
 * @property mixed company_details
 * @property mixed phone
 * @property mixed profession
 * @property mixed first_name
 * @property mixed last_name
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => $this->role->name,
            'company_details' => $this->company_details,
            'phone' => $this->phone,
            'profession' => $this->profession
        ];
    }
}

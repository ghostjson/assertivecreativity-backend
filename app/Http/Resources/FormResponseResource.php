<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed form_id
 * @property mixed response
 * @property mixed created_at
 * @property mixed form
 */
class FormResponseResource extends JsonResource
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
            'form_structure' => $this->form,
            'response' => $this->response,
            'created_at' => $this->created_at
        ];
    }
}

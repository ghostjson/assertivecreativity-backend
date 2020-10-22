<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed sender_id
 * @property mixed receiver_id
 * @property mixed order_id
 * @property mixed message_content
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed sender
 * @property mixed receiver
 * @property mixed order
 */
class ThreadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'order_id' => $this->order,
            'message_content' => $this->message_content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

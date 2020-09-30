<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

/**
 * @property int|mixed|string|null sender_id
 * @property mixed receiver_id
 * @property mixed order_id
 * @property mixed message_content
 */
class Thread extends Model
{
    use HasFactory;


    /**
     * Create a new thread
     * @param array $data
     * @return bool
     */
    public static function send(array $data) : bool
    {
        $thread = new Thread;

        $thread->sender_id = auth()->id();
        $thread->receiver_id = Order::find($data['order_id'])->seller_id;
        $thread->order_id = $data['order_id'];
        $thread->message_content = $data['message_content'];

        try{
            $thread->save();
            return true;
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return false;
        }
    }


    /**
     * Get sender object
     * @return BelongsTo
     */
    public function sender() : BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }

    /**
     * Get receiver object
     * @return BelongsTo
     */
    public function receiver() : BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'receiver_id', 'id');
    }


    /**
     * Get order object
     * @return BelongsTo
     */
    public function order() : BelongsTo
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
}

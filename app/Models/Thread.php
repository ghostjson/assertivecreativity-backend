<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Thread extends Model
{
    use HasFactory;

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

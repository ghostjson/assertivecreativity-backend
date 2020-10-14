<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

/**
 * @property int buyer_id
 * @property string order
 * @property int seller_id
 * @property string order_status
 * @property int product_id
 * @property mixed delivery_date
 * @method static find($order_id)
 * @method static where(string $string, int|string|null $id)
 */
class Order extends Model
{
    use HasFactory;


    /**
     * Create a new order
     * @param $data
     * @return bool
     */
    public static function new(array $data) : bool
    {
        $order = new Order;
        $order->buyer_id = auth()->id();
        $order->product_id = $data['product_id'];
        $order->data = $data['data'];
        $order->seller_id = Product::find($data['product_id'])->seller_id;
        $order->order_status = 'pending'; # pending/accepted/completed/cancelled
        $order->delivery_date = $data['delivery_date'];


        try{
            $order->save();
            return true;
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return false;
        }

    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get buyer object
     * @return BelongsTo
     */
    public function buyer() : BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'buyer_id', 'id');
    }

    /**
     * Get seller object
     * @return BelongsTo
     */
    public function seller() : BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'seller_id', 'id');
    }


    /**
     * Get product object
     * @return BelongsTo
     */
    public function product() : BelongsTo
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }



}

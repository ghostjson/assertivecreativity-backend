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
 * @property mixed data
 * @property mixed id
 * @method static find($order_id)
 * @method static where(string $string, int|string|null $id)
 * @method static orderBy(string $string, string $string1)
 */
class Order extends Model
{
    use HasFactory;


    /**
     * Create a new order
     * @param array $data
     * @param string $model
     * @return Order
     */
    public static function new(array $data, string $model) : Order
    {
        $order = new Order;
        $order->buyer_id = auth()->id();
        $order->product_id = $data['product_id'];
        $order->data = json_encode($data['data']);

        if($model == 'custom'){
            $product = CustomProduct::where('id', $data['product_id']);
            if($product->exists()){
                $order->seller_id = $product->first()->seller_id;
            }else{
                abort(404);
            }
        }else if($model = 'stock'){
            $product = StockProduct::where('id', $data['product_id']);
            if($product->exists()){
                $order->seller_id = $product->first()->owner;
            }else{
                abort(404);
            }
        }

        $order->order_status = 'pending'; # pending/accepted/completed/cancelled
        $order->delivery_date = json_encode($data['delivery_date']);


        try{
            $order->save();
            return $order;
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
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
        return $this->belongsTo('App\Models\CustomProduct', 'product_id', 'id');
    }



}

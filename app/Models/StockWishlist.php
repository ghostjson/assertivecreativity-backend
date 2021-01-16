<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @method static where(string $string, int|string|null $id)
 * @method static create(array $validated)
 */
class StockWishlist extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->user_id = auth()->id();
        });
    }

    public function getProductAttribute()
    {
        return StockProduct::find($this->product_id);
    }

    public function setOrderDataAttribute(array $value) : void
    {
        $this->attributes['order_data'] = json_encode($value);
    }

    public function getOrderDataAttribute(string $value)
    {
        return json_decode($value);
    }

    /**
     * Remove given product from wishlist
     * @param StockProduct $product
     * @return bool
     */
    public static function removeProduct(StockProduct $product) : bool
    {

        try {
            StockWishlist::where('product_id', $product->id)
                ->first()
                ->delete();
            return true;
        }catch (\Exception $exception)
        {
            Log::error($exception);
            return false;
        }
    }

    /**
     * Clear every product in the card
     * @return bool
     */
    public static function clear()
    {
        try {
            StockWishlist::where('user_id', auth()->id())->delete();
            return true;
        }catch (\Exception $exception) {
            Log::error($exception);
            return false;
        }
    }

    public function product()
    {
        return $this->belongsTo(StockProduct::class);
    }
}

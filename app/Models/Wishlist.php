<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @method static create(array $validated)
 * @method static where(string $string, int|string|null $id)
 */
class Wishlist extends Model
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
        return Product::find($this->product_id);
    }

    /**
     * Remove given product from wishlist
     * @param Product $product
     * @return bool
     */
    public static function removeProduct(Product $product) : bool
    {
        try {
            Wishlist::where('product_id', $product->id)
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
            Wishlist::where('user_id', auth()->id())->delete();
            return true;
        }catch (\Exception $exception) {
            Log::error($exception);
            return false;
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

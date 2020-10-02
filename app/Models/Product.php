<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed seller_id
 * @property mixed id
 * @method static create(array $validated)
 * @method static where(string $string, $id, $optional='')
 */
class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setSellerIdAttribute($value)
    {
        if(is_null($value))
        {
            $this->attributes['seller_id'] = auth()->id();
        }
        else
        {
                $this->attributes['seller_id'] = $value;
        }

    }


    /**
     * Get all tags of this products
     * @return Tag
     */
    public function tags() : Tag
    {
        return Tag::where('product_id', $this->id)->get();
    }

}

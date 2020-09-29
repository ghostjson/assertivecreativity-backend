<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed seller_id
 * @method static create(array $validated)
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

}

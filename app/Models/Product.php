<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\URL;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * @property mixed seller_id
 * @property mixed id
 * @property mixed Name
 * @method static create(array $validated)
 * @method static where(string $string, $id, $optional='')
 * @method static find($toArray)
 * @method static whereIn(string $string, $ids)
 * @method static search(string $search)
 * @method static select(string $string)
 */
class Product extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = [];

    public $searchable = [
      'columns' => [
          'products.name' => 10
      ]
    ];

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

    public function setPriceTableAttribute($value)
    {
        $this->attributes['price_table'] = json_encode($value);
    }

    public function setCustomFormsAttribute($value)
    {
        $this->attributes['custom_forms'] = json_encode($value);
    }

    public function getCustomFormsAttribute($value)
    {
        return json_decode($value);
    }

    public function getPriceTableAttribute($value)
    {
        return json_decode($value);
    }

    public function getImageAttribute($value)
    {
        return env('APP_URL').'/storage/'.$value;
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
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

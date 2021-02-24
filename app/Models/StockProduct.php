<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static select(string $string)
 * @method static updateOrCreate(array $array, array $array1)
 * @method static where(mixed $conditions, $name='', $s='')
 * @method static find($product_id)
 * @property mixed name
 * @property mixed product_key
 */
class StockProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getImageUrlListAttribute($value){
        return json_decode($value);
    }

    public function getDimensionUnitListAttribute($value)
    {
        return json_decode($value);
    }

    public function getDimensionTypeListAttribute($value)
    {
        return json_decode($value);
    }

    public function getQuantitiesListAttribute($value)
    {
        return json_decode($value);
    }

    public function getPriceListAttribute($value)
    {
        return json_decode($value);
    }

    public function getPiecesPerUnitListAttribute($value)
    {
        return json_decode($value);
    }

    public function getAddClrRunChgListAttribute($value)
    {
        return json_decode($value);
    }

    public function getImprintSizeListAttribute($value)
    {
        return json_decode($value);
    }

    public function getImprintSizeUnitsListAttribute($value)
    {
        return json_decode($value);
    }

    public function getImprintSizeTypeListAttribute($value)
    {
        return json_decode($value);
    }

    public function getSecondImprintSizeListAttribute($value)
    {
        return json_decode($value);
    }

    public function getSecondImprintUnitsListAttribute($value)
    {
        return json_decode($value);
    }

    public function getSecondImprintTypeListAttribute($value)
    {
        return json_decode($value);
    }



}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static select(string $string)
 * @method static where(string $string, $Name)
 */
class StockProduct extends Model
{
    use HasFactory;

    protected $guarded = [];
}

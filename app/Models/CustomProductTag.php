<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @method static create(array $array)
 */
class CustomProductTag extends Pivot
{
    use HasFactory;

    protected $guarded = [];

}

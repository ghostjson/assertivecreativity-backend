<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, $id)
 */
class Tag extends Model
{
    use HasFactory;


    /**
     * Get the category of the tag
     * @return BelongsTo
     */
    public function category() : BelongsTo #Category
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

}

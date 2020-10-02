<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, $id, string $optional='')
 * @property mixed products
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

    /**
     * Get all products that's under this tag
     * @return BelongsToMany
     */
    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    /**
     * Return the tags related to this category
     * @return Collection
     */
    public function tags() : Collection
    {
        return Tag::where('category_id', $this->id)->get();
    }
}

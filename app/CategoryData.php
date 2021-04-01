<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryData extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'category_id', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'seo_keywords'
    ];
}

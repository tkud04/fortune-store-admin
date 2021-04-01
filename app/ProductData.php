<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductData extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'product_id', 'amount', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'location', 'min_qty',
		'tax_class', 'shipping', 'date_available', 'length', 'width', 'height', 'category', 'manufacturer'
    ];
}

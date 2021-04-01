<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
        'id', 'product_id', 'cover', 'type', 'src_type', 'url', 'deleted', 'delete_token'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category', 'name', 'image', 'delete_token', 'parent_id', 'status'
    ];
    
}

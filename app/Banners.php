<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'subtitle_1', 'title', 'subtitle_2', 'type', 'cover', 'delete_token', 'status',
    ];
    
}

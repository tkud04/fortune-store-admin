<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'reference', 'amount', 'payment_id', 'shipping_id', 'payment_type', 'shipping_type', 'comment', 'status'
    ];
    
}

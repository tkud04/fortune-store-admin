<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'status', 'notify_customer', 'comment'
    ];
    
}

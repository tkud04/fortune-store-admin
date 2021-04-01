<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','fname', 'lname', 'company', 'address_1', 'address_2', 'city', 'region', 'zip', 'country'
    ];
    
}

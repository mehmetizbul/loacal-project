<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
}

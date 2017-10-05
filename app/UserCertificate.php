<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCertificate extends Model
{
    public function user(){
        return $this->belongsTo('App\User','user_id','id')->first();
    }

    public function certificate(){
        return $this->belongsTo('App\Certificate','certificate_id','id')->first();
    }

}

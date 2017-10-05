<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoacalApplication extends Model
{
    protected $fillable = [
        "user_id",
        "applicant_message",
        "accepted",
        "rejected"
    ];

    public function setAcceptedAttribute(){
        if(!$this->attributes["rejected"]) {
            $this->attributes["accepted"] = (boolean)(1);
            $this->save();
        }
    }

    public function setRejectedAttribute(){
        if(!$this->attributes["accepted"]) {
            $this->attributes["rejected"] = (boolean)(1);
            $this->save();
        }
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}

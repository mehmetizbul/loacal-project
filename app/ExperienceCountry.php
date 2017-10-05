<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienceCountry extends Model
{

    protected $fillable = [
        "country_id", "experience_id"
    ];
    public function country(){
        return $this->belongsTo('App\Country','country_id','id')->first();
    }

    public function experience(){
        return $this->belongsTo('App\Experience','experience_id','id')->first();
    }

    public function experienceREL(){
        return $this->belongsTo('App\Experience','experience_id','id');
    }
}

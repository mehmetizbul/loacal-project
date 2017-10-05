<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public static function countries(){
        return Country::where("parent","=",0)->orderBy('name')->get();
    }

    public static function cities($parent){
        return Country::where("parent","=",$parent)->orderBy('name')->get();
    }

    public function experience_country(){
        return $this->hasMany('App\ExperienceCountry')->get();
    }

}

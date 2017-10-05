<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienceLanguage extends Model
{
    public function language(){
        return $this->belongsTo('App\Language','language_id','id')->first();
    }

    public function experience(){
        return $this->belongsTo('App\Experience','experience_id','id')->first();
    }

    public static function distinct_languages(){
        $aLang = ExperienceLanguage::distinct()->select('language_id')->groupBy('language_id')->get()->toArray();
        $ret = [];
        foreach ($aLang as $language){
            $ret[] = Language::find($language)->first();
        }
        return $ret;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;


class Certificate extends Model
{
    const ICON_DIR = "images/certificates/";

    public function user_relations(){
        return $this->hasMany('App\UserCertificate','certificate_id','id')->get();
    }

    public function icon(){
        if($this->icon && file_exists(Certificate::ICON_DIR.$this->icon)){
            return URL::to('/')."/".Certificate::ICON_DIR.$this->icon;
        }
        return null;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class ExperienceCategories extends Model
{
    protected $fillable = [
        "experience_id","category_id"
    ];
    public function category(){
        return $this->belongsTo('App\Category','category_id','id')->first();
    }

    public function experience(){
        return $this->belongsTo('App\Experience','experience_id','id')->first();
    }

    public function experienceREL(){
        return $this->belongsTo('App\Experience','experience_id','id');
    }


}

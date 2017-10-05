<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienceResources extends Model
{
    protected $fillable=[
        "experience_id","title"
    ];
    public function experience(){
        return $this->belongsTo('App\Experience')->first();
    }
}

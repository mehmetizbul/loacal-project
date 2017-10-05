<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienceAdmin extends Model
{
    protected $fillable = [
        "user_id",
        "experience_id",
        "main"
    ];

    public function offlineExperience()
    {
        return $this->belongsTo('App\OfflineExperience','experience_id','id');
    }


    public function user(){
        return $this->belongsTo('App\User','user_id','id')->first();
    }

    public function liveExperiences(){
        return $this->hasOne('App\Experience', 'id', 'experience_id')->first();
    }

    public function draftExperiences(){
        return $this->hasOne('App\OfflineExperience', 'id', 'experience_id')
            ->whereStatus(ExperienceStatus::DRAFT)->first();
    }

    public function referanceDraftExperiences(){
        return $this->hasOne('App\OfflineExperience', 'created_from', 'experience_id')
            ->whereStatus(ExperienceStatus::DRAFT)->first();
    }

    public function pendingExperiences(){
        return $this->hasOne('App\OfflineExperience', 'id', 'experience_id')
            ->whereStatus(ExperienceStatus::PENDING)->first();
    }


}

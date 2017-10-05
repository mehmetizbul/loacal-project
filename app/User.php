<?php

namespace App;

use App\Messenger\Traits\Messagable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function loacal_applications(){
        return $this->hasMany('App\LoacalApplication');
    }

    public function setSlugAttribute($value){
        $value = str_replace(".","-",$value);

        if (!$value){
            $name = Functions::sanitizeStringForUrl($this->attributes["name"]);
            $slug = str_slug($name, '-');
        }else{
            $slug = Functions::sanitizeStringForUrl($value);
        }
        $existing = User::whereSlug($slug)->first();
        $i=0;
        while($existing && $existing != $this){
            $i++;
            $slug = $slug.$i;
            $existing = User::whereSlug($slug)->first();
        }
        $this->attributes["slug"] = $slug;
    }

    public function profile(){
        return $this->hasOne('App\UserProfile','user_id')->first();
    }

    public function admin(){
        return $this->hasMany('App\ExperienceAdmin')->get();
    }

    public function liveExperiences(){
        $aExp = [];
        $aAdmin = $this->admin();
        foreach($aAdmin as $oAdmin){
            if($oAdmin->liveExperiences()) {
                $aExp[] = $oAdmin->liveExperiences();
            }
        }
        $aTmp = Experience::whereUserId($this->id)->get();
        foreach($aTmp as $oExp) {
            if(!$oExp->admin())
                $aExp[] = $oExp;
        }
        return $aExp;
    }

    public function draftExperiences(){
        $aExp = [];
        $aAdmin = $this->admin();
        foreach($aAdmin as $oAdmin){
            if($oAdmin->draftExperiences()) {
                $oExp = $oAdmin->draftExperiences();
                $aExp[] = $oExp;
            }
        }

        foreach(OfflineExperience::whereUserId($this->id)->whereStatus(ExperienceStatus::DRAFT)->get() as $oExp){
            if(!$oExp->admin(true)){
                $aExp[] = $oExp;
            }
        }

        return $aExp;
    }

    public function pendingExperiences(){
        $aExp = [];
        $aAdmin = $this->admin();
        foreach($aAdmin as $oAdmin){
            if($oAdmin->pendingExperiences()) {
                $oExp = $oAdmin->pendingExperiences();
                $aExp[] = $oExp;
            }
        }
        foreach(OfflineExperience::whereUserId($this->id)->whereStatus(ExperienceStatus::PENDING)->get() as $oExp){
            if(!$oExp->admin(true)){
                $aExp[] = $oExp;
            }
        }
        return $aExp;
    }

    public function certificates(){
        $aUC = $this->hasMany('App\UserCertificate')->get();
        $aCerts = [];
        foreach($aUC as $oUC){
            $aCerts[] = $oUC->certificate();
        }
        return $aCerts;
    }

    public function initProfile(){
        UserProfile::updateOrCreate([
            "user_id" => $this->getAttribute('id'),
            "profile" => "",
            "notes" => ""
        ]);
    }
    public function setLogo($value){
        $o = $this->profile();
        $o->attributes["logo"]= $value;
        $o->save();
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     */
    public function detachAllRoles()
    {
        $roles = $this->roles()->get();
        foreach($roles as $role) {
            $this->detachRole($role);
        }
    }

    public static function getLogoDir($full=true){
        return $full ? "images/uploads/".date("Y")."/".date("m")."/" : date("Y")."/".date("m")."/";
    }

    public function orders(){
        return $this->hasMany('App\BookingPayment');
    }
}


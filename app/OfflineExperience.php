<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class OfflineExperience extends Model
{
    protected $fillable = [
        "id",
        "sku",
        "created_from",
        "status",
        "user_id",
        "title",
        "description",
        "child_friendly",
        "disabled_friendly",
        "availability",
        "transportation",
        "accommodation",
        "slug",
        "menu_order",
        "duration",
        "duration_unit",
        "purchase_note",
        "cancellation_policy"
    ];

    public function makeLive(){
        if($this->created_from){
            $oExp = Experience::find($this->created_from);
            if($oExp) {
                $oExp->archive();
            }
        }
        $data = $this->getAttributes();

        $data["status"] = "";
        $oExp = Experience::create($data);
        $this->delete();
        return $oExp;
    }
    public function archive(){
        $this->status = ExperienceStatus::ARCHIVE;
        $this->slug = "";
        $this->save();
    }

    public function setAvailabilityAttribute($value){

        if(is_array($value)){
            $this->attributes["availability"] = json_encode($value);

        }else{
            $this->attributes["availability"] = "[]";
        }
    }

    public function availability(){
        return json_decode($this->availability);
    }

    public function categories(){
        $aCat = $this->hasMany('App\ExperienceCategories','experience_id','id')->get();
        $aRet = [];
        foreach($aCat as $oCat){
            $aRet[] = $oCat->category();
        }
        return $aRet;

    }

    public function languages(){
        $aLang = $this->hasMany('App\ExperienceLanguage','experience_id','id')->get();
        $aRet = [];
        foreach($aLang as $oLang){
            $aRet[] = $oLang->language()->id;
        }
        return $aRet;
    }

    public function countries(){
        $aCoun = $this->hasMany('App\ExperienceCountry','experience_id','id')->get();
        $aRet = [];
        foreach($aCoun as $oCoun) {
            $id = $oCoun->country()->id;
            $parent = $oCoun->country()->parent;
            if (!$parent) {
                if (!isset($aRet[$id])) {
                    $aRet[$id] = [];
                }
            } else {
                $parentparent = Country::find($parent);
                if (!$parentparent->parent) {
                    $aRet[$parent][$id] = [];
                }else{
                    $aRet[$parentparent->parent][$parent][] = $id;
                }
            }
        }

        return $aRet;
    }

    public function author(){
        return $this->belongsTo('App\User','user_id','id')->first();
    }

    public function setAdmin($user_id,$main=1){
        if($main && $this->admin(true)){
            $admin = $this->hasOne('App\ExperienceAdmin','id','experience_id')->whereMain(1);
            if($admin){
                $admin->main = 0;
                $admin->save();
            }
        }
        ExperienceAdmin::updateOrCreate(
            [
                'experience_id' => $this->id,
                "user_id"       => $user_id
            ],
            [
                'main'          => $main
            ]
        );
    }

    /**
     * @param int $all
     * @return mixed
     * if $all is set to 0 (by default it is set to 0), the function returns only the main admin of the experience
     * if its set to 1, function returns all admins
     */
    public function admin($all=false){
        if($all){
            $aAdmin = $this->hasMany('App\ExperienceAdmin','experience_id','id')->get();
            $aUser = [];
            if(count($aAdmin)) {
                foreach ($aAdmin as $oAdmin) {
                    $aUser[] = $oAdmin->user();
                }
            }
            if(!count($aUser)) return null;
            return $aUser;
        }else {
            $oAdmin = $this->hasOne('App\ExperienceAdmin','experience_id','id')->whereMain(1)->first();
            if(!$oAdmin) return null;
            return $oAdmin->user();
        }
    }

    public function images(){
        return $this->hasMany('App\ExperienceImages','experience_id','id')->whereThumbnail(0)->get();
    }

    public function thumbnail(){
        return $this->hasOne('App\ExperienceImages','experience_id','id')->whereThumbnail(1)->first();
    }

    public function setThumbnail($image_file,$destructive=true){
        $oThumb = $this->hasOne('App\ExperienceImages','experience_id','id')->whereThumbnail(1)->first();
        if($destructive){
            if($oThumb){
                if ( File::exists( public_path().$oThumb->image_file ) )
                {
                    File::delete( public_path().$oThumb->image_file );
                }
                $oThumb->delete();
            }
            ExperienceImages::create([
                "image_file"    =>  $image_file,
                "experience_id" => $this->id,
                "thumbnail"     => 1,
                "icon_file"      => ""
            ]);
        }else{
            if($oThumb){
                $oThumb->thumbnail=0;
                $oThumb->save();
            }
            $oThumb = ExperienceImages::whereExperienceId($this->id)->whereImageFile($image_file)->first();
            if($oThumb){
                $oThumb->thumbnail=1;
                $oThumb->save();
            }
        }
    }

    public function prices(){
        return $this->hasMany('App\ExperiencePrices','experience_id','id')->get();
    }

    public function resources(){
        return $this->hasMany('App\ExperienceResources','experience_id','id')->get();
    }

    public static function getNewMenuOrder(){
        $last = (int)Experience::max("menu_order") ?: 0;
        return $last+1;
    }

    public function setMenuOrderAttribute(){
        $this->attributes["menu_order"] = OfflineExperience::getNewMenuOrder();
    }

    public function setTitleAttribute($value){
        if($value === NULL){
            $value = "";
        }
        $this->attributes["title"] = $value;
    }

    public function setLocationAttribute($value){
        if($value === null){
            $value = "";
        }
        $this->attributes["location"] = $value;
    }
    public function setDescriptionAttribute($value){
        if($value === NULL){
            $value = "";
        }
        $this->attributes["description"] = $value;
    }
}

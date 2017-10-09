<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Log;
use DB;
class Experience extends Model
{
    protected $fillable = [
        "id",
        "sku",
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

    const TRANS_ACCOM =[
        "0" =>  "",
        "1" =>  "Included in price",
        "2" =>  "Available upon request (free)",
        "3" =>  "Available upon request (extra fee)"
    ];

    public function transportation_text(){
        $transportation = $this->transportation;
        if(!$this->transportation) $transportation = 0;
        return Experience::TRANS_ACCOM[$transportation];
    }

    public function accommodation_text(){
        $accommodation = $this->accommodation;
        if(!$this->accommodation) $accommodation = 0;
        return Experience::TRANS_ACCOM[$accommodation];
    }

    public function calculate_price($adults=0,$children=0,$extras = []){

        $adultsprice=0;
        $childrenprice=0;
        $extrasprice = 0;
        if($adults) {
            //adult price
            $oPrices = $this->prices()->where([
                ["price_type", "LIKE", "total"],
                ["type", "LIKE", "adults"],
                ["min", "<=", $adults],
                ["max", ">=", $adults]
            ])->first();
            if(is_null($oPrices)) {
                $oPrices = $this->prices()->where([
                    ["price_type", "LIKE", "total"],
                    ["type", "LIKE", "adults"],
                    ["min", "<=", $adults],
                    ["max", "=", 0]
                ])->first();
            }

            if (!is_null($oPrices)) {
                $adultsprice = $oPrices->getAttribute("price");
            } else {
                $oPrices = $this->prices()->where([
                    ["price_type", "LIKE", "persons"],
                    ["type", "LIKE", "adults"],
                    ["min", "<=", $adults],
                    ["max", ">=", $adults]
                ])->first();

                if(is_null($oPrices)){
                    $oPrices = $this->prices()->where([
                        ["price_type", "LIKE", "persons"],
                        ["type", "LIKE", "adults"],
                        ["min", "<=", $adults],
                        ["max", "=", 0]
                    ])->first();
                }

                if (!is_null($oPrices)) {
                    $adultsprice = $adults * $oPrices->getAttribute("price");

                }
            }
        }

        if($children) {
            //children price
            $oPrices = $this->prices()->where([
                ["price_type", "LIKE", "total"],
                ["type", "LIKE", "children"],
                ["min", "<=", $children],
                ["max", ">=", $children]
            ])->first();

            if(is_null($oPrices)) {
                $oPrices = $this->prices()->where([

                    ["price_type", "LIKE", "total"],
                    ["type", "LIKE", "children"],
                    ["min", "<=", $children],
                    ["max", "=", 0]
                ])->first();
            }

            if (!is_null($oPrices)) {
                $childrenprice = $oPrices->getAttribute("price");

            } else {
                $oPrices = $this->prices()->where([
                    ["price_type", "LIKE", "persons"],
                    ["type", "LIKE", "children"],
                    ["min", "<=", $children],
                    ["max", ">=", $children]
                ])->first();
                if(is_null($oPrices)) {
                    $oPrices = $this->prices()->where([
                        ["price_type", "LIKE", "persons"],
                        ["type", "LIKE", "children"],
                        ["min", "<=", $children],
                        ["max", "=", 0]
                    ])->first();
                }
                if (!is_null($oPrices)) {
                    $childrenprice = $children * $oPrices->getAttribute("price");
                }
            }
        }
        if(count($extras)){
            foreach($extras as $extra){
                $oRes = ExperienceResources::find($extra);
                if(!is_null($oRes)){
                    $extrasprice += $oRes->cost;
                }
            }
        }

        return [
            "adults_price"=>$adultsprice,
            "children_price"=>$childrenprice,
            "extras_price"=>$extrasprice
        ];

    }

    public function display_price(){
        $show = 0;
        $aPrices = $this->prices()->whereType("adults")->get();
        foreach($aPrices as $price){

            if($price["price"] == 0)
                $tmp = $this->minResourcePrice();

            else
            {
                $min = $price["min"];
                $max = $price["max"];
                if($min && !$max){
                    $max = $min;
                }

                if($price["price_type"] == "total"){
                    $tmp = $price["price"]/$max;
                }else{
                    $tmp = $price["price"];
                }
            }

            if(!$show){
                $show = $tmp;
            }else if($tmp<$show){
                $show = $tmp;
            }
        }
        return number_format(round($show * 2, 0)/2, 2, '.', '');
    }

    public function getEditInProgress(){
        $oExp = OfflineExperience::whereCreatedFrom($this->id)->whereStatus(ExperienceStatus::DRAFT)->first();
        return $oExp;
    }

    public function make_editable()
    {
        $data = $this->getAttributes();

        $data["created_from"] = $this->id;
        $data["status"] = ExperienceStatus::DRAFT;
        $oInd = Index::whereTable("experience")->first();
        $data["id"] = $oInd->newIndex();
        $data["availability"] = $this->availability();

        $newExp = OfflineExperience::create($data);

        $oInd->updateIndex($data["id"]);

        $aCountries = $this->hasMany('App\ExperienceCountry')->get()->toArray();
        foreach ($aCountries as $key => $tmp) {
            unset($aCountries[$key]["id"]);
            $aCountries[$key]["experience_id"] = $data["id"];
        }
        //Log::info("Countries:".print_r($aCountries,true));
        ExperienceCountry::insert($aCountries);

        $aLang = $this->hasMany('App\ExperienceLanguage')->get()->toArray();
        foreach ($aLang as $key => $tmp) {
            unset($aLang[$key]["id"]);
            $aLang[$key]["experience_id"] = $data["id"];
        }
        //Log::info("Lang:".print_r($aLang,true));
        ExperienceLanguage::insert($aLang);

        $aCats = $this->hasMany('App\ExperienceCategories')->get()->toArray();
        foreach ($aCats as $key => $tmp) {
            unset($aCats[$key]["id"]);
            $aCats[$key]["experience_id"] = $data["id"];
        }
        //Log::info("Categories:".print_r($aCats,true));
        ExperienceCategories::insert($aCats);

        $aIm = $this->hasMany('App\ExperienceImages')->get()->toArray();
        foreach ($aIm as $key => $tmp) {
            unset($aIm[$key]["id"]);
            $aIm[$key]["experience_id"] = $data["id"];
        }
        ExperienceImages::insert($aIm);


        $aP = $this->prices()->get();

        if(count($aP)) {
            foreach ($aP as $price)
            {
                $tmp = $price->toArray();
                //Log::info("Prices:".print_r($tmp,true));
                unset($tmp["id"]);
                $tmp["experience_id"] = $data["id"];
                ExperiencePrices::insert($tmp);
            }
        }

        $aRes = $this->resources()->toArray();
        foreach($aRes as $key=>$tmp){
            unset($aRes[$key]["id"]);
            $aRes[$key]["experience_id"] = $data["id"];
        }
        //Log::info("Resources:".print_r($aRes,true));
        ExperienceResources::insert($aRes);

        $aAdmin = $this->hasMany('App\ExperienceAdmin')->get()->toArray();
        foreach($aAdmin as $key=>$tmp){
            unset($aAdmin[$key]["id"]);
            $aAdmin[$key]["experience_id"] = $data["id"];
        }
        //Log::info("Admins:".print_r($aAdmin,true));
        ExperienceAdmin::insert($aAdmin);

        return $newExp;
    }

    public function setSlugAttribute($value)
    {
        if (!isset($this->attributes["slug"])){
            $title = Functions::sanitizeStringForUrl($this->attributes["title"]);
            $slug = str_slug($title, '-');
            $existing = Experience::whereSlug($slug)->where("id","!=",($this->getAttribute("created_from")))->first();
            $i=0;

            while($existing){
                $i++;
                $slug = $slug.$i;
                $existing = Experience::whereSlug($slug)->first();
            }
            $value = $slug;
        }
        $this->attributes["slug"] = $value;
    }

    public function archive(){
        $data = $this->getAttributes();
        $data["status"] = ExperienceStatus::ARCHIVE;
        $data["availability"] = $this->availability();

        OfflineExperience::create($data);
        $this->delete();
    }

    public function availability(){
        return json_decode($this->availability);
    }

    public function categories(){
        $aCat = $this->hasMany('App\ExperienceCategories')->get();
        $aRet = [];
        foreach($aCat as $oCat){
            $aRet[] = $oCat->category();
        }
        return $aRet;

    }

    public function categoriesREL(){
        return $this->hasMany('App\ExperienceCategories');
    }

    public function languages(){
        $aLang = $this->hasMany('App\ExperienceLanguage')->get();
        $aRet = [];
        foreach($aLang as $oLang){
            $aRet[] = $oLang->language();
        }
        return $aRet;
    }

    public function languagesREL(){
        return $this->hasMany('App\ExperienceLanguage');
    }

    public function countries(){
        $aCoun = $this->hasMany('App\ExperienceCountry')->get();
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

    public function experiencecountry(){
        return $this->hasMany('App\ExperienceCountry');
    }

    public function author(){
        return $this->belongsTo('App\User','user_id','id')->first();
    }

    /**
     * @param int $all
     * @return mixed
     * if $all is set to 0 (by default it is set to 0), the function returns only the main admin of the experience
     * if its set to 1, function returns all admins
     */
    public function admin($all=false){
        if($all){
            $aAdmin = $this->hasMany('App\ExperienceAdmin')->get();
            $aUser = [];
            if(count($aAdmin)) {
                foreach ($aAdmin as $oAdmin) {
                    $aUser[] = $oAdmin->user();
                }
            }
            if(!count($aUser)) return null;
            return $aUser;
        }else {
            $oAdmin = $this->hasOne('App\ExperienceAdmin')->whereMain(1)->first();
            if(!$oAdmin) return null;
            return $oAdmin->user();
        }
    }



    public function images(){
        return $this->hasMany('App\ExperienceImages')->get();
    }

    public function thumbnail(){
        $ret = $this->hasOne('App\ExperienceImages')->whereThumbnail(1)->first();
        if(!$ret){
            $ret = $this->hasMany('App\ExperienceImages')->first();
        }
        return $ret;
    }

    public function prices(){
        return $this->hasMany('App\ExperiencePrices','experience_id','id');
    }

    public function resources(){
        return $this->hasMany('App\ExperienceResources')->get();
    }

    public function minResourcePrice(){
        return $this->hasMany('App\ExperienceResources')->min('cost');
    }
}

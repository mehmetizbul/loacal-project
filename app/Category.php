<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Category extends Model
{

    protected $fillable = [
        "name",
        "slug",
        "parent"
    ];

    const UNKNOWN_ICON = "/images/general/unknown.png";

    const ICON_DIR = "images/categories/";

    public function setSlugAttribute($value){
        $value = str_replace(".","-",$value);

        if (!$value){
            $name = Functions::sanitizeStringForUrl($this->attributes["name"]);
            $slug = str_slug($name, '-');
        }else{
            $slug = Functions::sanitizeStringForUrl($value);
        }
        $existing = Category::whereSlug($slug)->first();
        $i=0;
        while($existing && $existing != $this){
            $i++;
            $slug = $slug.$i;
            $existing = Category::whereSlug($slug)->first();
        }
        $this->attributes["slug"] = $slug;
    }

    public function experiences(){
        $aExpCat = $this->hasMany('App\ExperienceCategories','category_id','id');

        return $aExpCat;
    }

    public function icon(){
        if($this->icon && file_exists(Category::ICON_DIR.$this->icon)){
            return URL::to('/')."/".Category::ICON_DIR.$this->icon;
        }else{
            return URL::to('/')."/".Category::UNKNOWN_ICON;
        }
        return null;
    }

    public static function main_categories(){
        return Category::with('experiences')->whereParent(0)->get()->sortBy(function($cat)
        {
            return $cat->experiences->count();
        },SORT_REGULAR,true);
    }

    public static function oldExperienceFormData($data){

        return Category::whereIn('id', $data)->get();
    }

}

<?php

namespace App\Http\Controllers;

use App\Category;
use App\ExperienceCountry;
use App\ExperienceStatus;
use App\OfflineExperience;
use Illuminate\Http\Request;
use App\Experience;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Country;
use Log;

class ExperiencesController extends Controller
{
    public function index(Request $request)
    {
        $query = Experience::query();
        $meta = $request->get('filter');
        if(!is_null($request->get('search')) && !empty($request->get('search'))){
            $meta["search"] = $request->get('search');
        }

        $tmpaExp = $query->distinct()->get();
        $filter_range_min = 0;
        $filter_range_max = 0;

        foreach($tmpaExp as $oExp){
            $price = $oExp->display_price();
            if($filter_range_min == 0) $filter_range_min = $price;
            if($price < $filter_range_min) $filter_range_min = $price;
            if($price > $filter_range_max) $filter_range_max = $price;
        }
        $filter_range_min = floor($filter_range_min/50)*50;        //$filter_range_max = ceil($filter_range_max * 2)/2;
        $filter_range_max =ceil($filter_range_max/50)*50;        //$filter_range_max = ceil($filter_range_max * 2)/2;

        $meta["filter_range_from"] = $filter_range_min;
        $meta["filter_range_to"] = $filter_range_max;



        if(isset($meta["search"]) && !empty($meta["search"])){
            $keyword =$meta["search"];
            $query->where("title", "like", "%$keyword%")->orWhere("description", "like", "%$keyword%");
        }

        if(isset($meta["categories"]) && !empty($meta["categories"])){
            $query->leftJoin('experience_categories','experiences.id','=','experience_categories.experience_id')
                ->whereIn('experience_categories.category_id',$meta["categories"]);
        }

        if(isset($meta["languages"]) && !empty($meta["languages"])){
            $query->leftJoin('experience_languages','experiences.id','=','experience_languages.experience_id')
                ->whereIn('experience_languages.language_id',$meta["languages"]);
        }
        if(isset($meta["loacal-accommodation"])){
            $query->where('accommodation','=',$meta["loacal-accommodation"]);
        }

        if(isset($meta["loacal-transport"])){
            $query->where('transportation','=',$meta["loacal-transport"]);
        }

        if(isset($meta["child_friendly"])){
            $query->where('child_friendly','=',1);
        }

        if(isset($meta["disabled_friendly"])){
            $query->where('disabled_friendly','=',1);
        }


        $no_of_people = null;
        if(isset($meta["no_of_people"]) && !empty($meta["no_of_people"]) && intval($meta["no_of_people"]) > 0){
            $no_of_people = intval($meta["no_of_people"]);
            $query->leftJoin('experience_prices','experiences.id','=','experience_prices.experience_id')
                ->where('max','>=',$no_of_people)
                ->where('min','<=',$no_of_people);
            $meta["no_of_people"] = $no_of_people;
        }

        $aExp = $query->distinct()->get();

        $min_price = 0;
        $max_price = 0;
        if(isset($meta["free_experience"])) {
            foreach($aExp as $key=>$oExp){
                $price = $oExp->display_price();
                if($price == 0) {
                    $min_price = 0;
                }else{
                    $aExp->forget($key);
                }
            }
        }elseif(isset($meta["price_range"])){
            $selected_min_price = explode(',',$meta["price_range"])[0];
            $selected_max_price = explode(',',$meta["price_range"])[1];
            foreach($aExp as $key=>$oExp){

                $price = $oExp->display_price();
                if($price >= $selected_min_price && $price <= $selected_max_price) {
                    if ($min_price == 0) $min_price = $price;
                    if ($price < $min_price) $min_price = $price;
                    if ($price > $max_price) $max_price = $price;
                }else{
                    $aExp->forget($key);
                }
            }
        }
        if($min_price == 0){
            $min_price = $filter_range_min;
        }

        if($max_price == 0){
            $max_price = $filter_range_max;
        }

        $meta["price_range_from"] = $min_price;
        $meta["price_range_to"] = $max_price;



        if(isset($meta["date_from"]) && isset($meta["date_to"])
            && !empty($meta["date_from"]) && !empty($meta["date_to"])
            && strtotime($meta["date_to"]) >= strtotime($meta["date_from"])){
            $week = [7,1,2,3,4,5,6];
            $from = strtotime(str_replace('/', '-', $meta["date_from"]));
            $to = strtotime(str_replace('/', '-', $meta["date_to"]));
            $days = [];

            while($from<=$to){
                $days[] = $week[date("w",$from)];
                $days = array_unique($days);
                $from = strtotime("next day",$from);
            }
            foreach($aExp as $key=>$oExp){
                $expdays = $oExp->availability();
                if(!count(array_intersect($expdays,$days))){
                    $aExp->forget($key);
                }
            }
        }

        $perPage = 20;

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $aExp->slice(($currentPage) * $perPage, $perPage);
        $aExp = new LengthAwarePaginator(
            $aExp,
            $aExp->count(),
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]
        );


        return view('experience.index',compact('aExp','meta'));
    }

    public function manage($status=ExperienceStatus::LIVE){
        $aExp = [];
        switch ($status){
            case ExperienceStatus::LIVE:
                $aExp = Experience::paginate(10);
                break;
            case ExperienceStatus::PENDING:
                $aExp = OfflineExperience::whereStatus(ExperienceStatus::PENDING)->paginate(10);
                break;
            case ExperienceStatus::DRAFT:
                $aExp = OfflineExperience::whereStatus(ExperienceStatus::DRAFT)->paginate(10);
                break;
            case ExperienceStatus::ARCHIVE:
                $aExp = OfflineExperience::whereStatus(ExperienceStatus::ARCHIVE)->paginate(10);
                break;
        }
        return view('experience.manage',compact('aExp','status'));
    }

    public function make_editable($id){
        $oExp = Experience::find($id);
        $oOffline = $oExp->getEditInProgress();
        if(is_null($oOffline)){
            $oExp = $oExp->make_editable();
        }else{
            $oExp = $oOffline;
        }
        $id = $oExp->id;
        return redirect(route('experience.edit',compact('id')));
    }

    public function homepage(){

        $loacalExperiences = Experience::with('experiencecountry', 'categoriesREL')
            ->whereHas('experiencecountry', function($query) {
                $query->wherein('country_id', [127,128]);
            })->whereHas('categoriesREL', function($query) {
                $query->where('category_id', 500);
            })->get()->random(10);

        $countries = Country::countries();

        $aTopExperiences = Experience::whereHas('experiencecountry', function($query)  {
                $query->wherein('experience_id', [942, 4771, 3601, 6160, 4679, 6150, 6196]);//Cyprus tops
        })->with('experiencecountry')->get();


        return view('index',compact('aTopExperiences','loacalExperiences','countries'));
    }

    public function dynamictopexperience(Request $request)
    {

        $aTopExperiences = Experience::whereHas('experiencecountry', function($query) use($request) {
            if($request->input('country') == 127)//Cyprus
                $query->wherein('experience_id', [942, 4771, 3601, 6160, 4679, 6150, 6196]);
            else if($request->input('country') == 128)//Turkey
                $query->wherein('experience_id', [6199,3591,5493,1345,1898, 4480, 6188, 5201]);
            else
                $query->where('country_id', $request->input('country'));
        })->with('experiencecountry')->get();


        return view('experience.dynamictopexperience',compact('aTopExperiences'))->render();
    }


    public function dynamicwithlocal(Request $request)
    {
        $loacalExperiences = Experience::with('experiencecountry', 'categoriesREL')
            ->whereHas('experiencecountry', function($query) use($request){
                $query->where('country_id', $request->input('country'));
            })->whereHas('categoriesREL', function($query) {
                $query->where('category_id', 500);
            })->get()->random(10);

        return view('experience.dynamicwithlocal',compact('loacalExperiences'))->render();
    }

    public function show($slug)
    {
        $oExp = Experience::whereSlug($slug)->first();
        return view("experience.show", compact("oExp"));
    }

    public function destroy($id,Request $request)
    {
        $status = $request->input('status');
        $oExp = Experience::find($id);
        if($oExp) {
            $oExp->archive(false);
        }else{
            $oExp = OfflineExperience::find($id);
            $oExp->archive(true);
        }
        return redirect(route("experience.manage",compact('status')))
            ->with('success','Experience archived successfully');
    }
}
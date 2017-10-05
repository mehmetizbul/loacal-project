<?php

namespace App\Http\Controllers;
use App\Experience;
use App\ExperienceAdmin;
use App\User;
use Session;
use Validator;
use DB;
use App\ExperienceCategories;
use App\ExperienceCountry;
use App\ExperienceLanguage;
use App\ExperienceStatus;
use App\Index;
use App\OfflineExperience;
use Illuminate\Http\Request;
use App\ExperiencePrices;
use App\Logic\Image\ImageRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use App\Functions;
use App\ExperienceResources;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;


class OfflineExperiencesController extends Controller
{
    protected $image;
    public function __construct(ImageRepository $imageRepository)
    {
        $this->image = $imageRepository;
    }

    public function create()
    {
        $owners = User::orderBy('name')->get();
        return view('experience.edit', ['owners' => $owners]);
    }


    public function edit($id)
    {
        $oExp = OfflineExperience::find($id);
        $owners = User::orderBy('name')->get();

        if($oExp->status != ExperienceStatus::DRAFT) dd("This experience is not editable (status is not ".ExperienceStatus::DRAFT.")");
        return view('experience.edit',compact('oExp'), compact('owners'));

    }

    public function view($id){
        $oExp = OfflineExperience::find($id);
        $owners = User::orderBy('name')->get();

        return view('experience.edit',compact('oExp'), compact('owners'))->with('view',true);
    }

    public function store(Request $request){

        $all = $request->all();

        $messages = [
            'location.country.required' => 'Please select the country.',
            'location.city.required' => 'Please select the city.',
            'category.required' => 'The "Selected Categories" section should include at least one main category.',
            'prices.*.min.filled' => 'The person (min) should be filled.',
            'prices.*.min.min' => 'The minimum person should be 1.',
            'prices.*.max.filled' => 'The person (max) should be filled.',
            'prices.*.max.min' => 'The maximum person should be at least 1.',
            'prices.*.price.filled' => 'The price should be filled (0 if experience is free).',
            'availability.required' => 'At least one available day should be selected.',
            'language.required' => 'At least one language should be selected.',
        ];

        $validator = Validator::make($all, [
            'title' => 'required|unique:experiences,title',
            'location.country' => 'required',
            'location.city' => 'required',
            'description' => 'min:100',
            'category' => 'required',
            'duration' => 'required',
            'prices.*.min' => 'filled|numeric|min:1',
            'prices.*.max' => 'filled|numeric|min:1',
            'prices.*.price' => 'filled|numeric',
            'language' => 'required',
            'availability' => 'required',

        ],$messages);



        if ($validator->fails())
        {
            Session::flash('prices', $all["prices"]);
            Session::flash('resources', $all["resources"]);
            Session::flash('location', $all["location"]);


            return redirect()->back()->withErrors($validator)->withInput();

        }

        if(isset($all["child_friendly"])){
            $all["child_friendly"] = 1;
        }else{
            $all["child_friendly"] = 0;
        }

        if(isset($all["disabled_friendly"])){
            $all["disabled_friendly"] = 1;
        }else{
            $all["disabled_friendly"] = 0;
        }
        if(!isset($all["purchase_note"])) $all["purchase_note"] = "";
        if(!isset($all["cancellation_policy"])) $all["cancellation_policy"] = "";

        $all["status"] = ExperienceStatus::DRAFT;
        $all["sku"] = uniqid();

        $message = "Experience has been created successfully and has been saved as draf. You can edit your entry in your drafts";

        $oInd = Index::whereTable("experience")->first();
        $all["id"] = $oInd->newIndex();

        $all["slug"] = "";
        $oExp = OfflineExperience::create($all);
        $oInd->updateIndex($all["id"]);

        if(isset($all["prices"])){
            foreach($all["prices"] as $aP){
                $min = $aP["min"];
                $max = $aP["max"];
                $price = $aP["price"];
                $type = $aP["type"];
                $price_type = $aP["price_type"];

                if(!($min && $max && $price && $type && $price_type)) continue;

                $aPrices = [
                    "experience_id" =>  $all["id"],
                    "min"           =>  $min,
                    "max"           =>  $max,
                    "price"         =>  $price,
                    "price_type"    =>  $price_type,
                    "type"          =>  $type
                ];
                ExperiencePrices::create($aPrices);
            }
        }

        if (isset($all["location"])) {
            foreach ($all["location"] as $data) {
                foreach($data as $country){
                    if ($country) {
                        $aCountries[] = [
                            "experience_id" => $oExp->id,
                            "country_id" => $country
                        ];
                    }
                }
            }
            ExperienceCountry::insert($aCountries);
        }

        if(isset($all["category"])) {
            $aCats = [];
            foreach ($all["category"] as $category) {
                if($category) {
                    $aCats[] = [
                        "experience_id" => $oExp->id,
                        "category_id" => $category
                    ];
                }
            }
            ExperienceCategories::insert($aCats);
        }


        if(isset($all["language"])) {
            $aLang = [];
            foreach ($all["language"] as $lang) {
                if($lang) {
                    $aLang[] = [
                        "experience_id" => $oExp->id,
                        "language_id" => $lang
                    ];
                }
            }
            ExperienceLanguage::insert($aLang);
        }

        if(isset($all["resources"])){
            $aRes = [];
            foreach($all["resources"] as $res){
                $title = $res["title"];
                $price = $res["price"];
                if($title && $price){
                    $aRes[] = [
                        "experience_id" => $all["id"],
                        "title" =>  $title,
                        "cost" =>  $price
                    ];
                }
            }
            ExperienceResources::insert($aRes);
        }

        if($all["owner"] != 0)
        {
            $oExp->setAdmin($all["owner"],1);
        }
        else
        {
            $oExp->setAdmin($all["user_id"],1);
        }

        return redirect('/experience/'.$oExp->id.'/edit')
            ->with('success', $message);
    }

    public function update(Request $request, $id)
    {
        $all = $request->all();

        $messages = [
            'location.country.required' => 'Please select the country.',
            'location.city.required' => 'Please select the city.',
            'category.required' => 'The "Selected Categories" section should include at least one main category.',
            'prices.*.min.filled' => 'The person (min) should be filled.',
            'prices.*.min.min' => 'The minimum person should be 1.',
            'prices.*.max.filled' => 'The person (max) should be filled.',
            'prices.*.max.min' => 'The maximum person should be at least 1.',
            'prices.*.price.filled' => 'The price should be filled (0 if experience is free).',
            'availability.required' => 'At least one available day should be selected.',
            'language.required' => 'At least one language should be selected.',
        ];

        $oExp = OfflineExperience::find($id);
        $oLive = Experience::find($oExp->getAttribute("created_from"));
        $self = "";
        if(!is_null($oLive)){
            $self = $oLive->getAttribute("id");

        }

        $validator = Validator::make($all, [
            'title' => 'required|unique:experiences,title,'.$self,
            'location.country' => 'required',
            'location.city' => 'required',
            'description' => 'min:100',
            'category' => 'required',
            'duration' => 'required',
            'prices.*.min' => 'filled|numeric|min:1',
            'prices.*.max' => 'filled|numeric|min:1',
            'prices.*.price' => 'filled|numeric',
            'language' => 'required',
            'availability' => 'required',

        ],$messages);

        Session::flash('prices', $all["prices"]);
        Session::flash('resources', $all["resources"]);


        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(isset($all["child_friendly"])){
            $all["child_friendly"] = 1;
        }else{
            $all["child_friendly"] = 0;
        }

        if(isset($all["disabled_friendly"])){
            $all["disabled_friendly"] = 1;
        }else{
            $all["disabled_friendly"] = 0;
        }


        $aCountries = [];

        if (isset($all["location"])) {
            foreach ($all["location"] as $data) {
                foreach($data as $country){
                    if ($country) {
                        $aCountries[] = [
                            "experience_id" => $oExp->id,
                            "country_id" => $country
                        ];
                    }
                }
            }
        }
        DB::table('experience_countries')->where('experience_id', '=', $id)->delete();
        ExperienceCountry::insert($aCountries);



        $aCats = [];
        if (isset($all["category"])) {
            foreach ($all["category"] as $category) {
                $aCats[] = [
                    "experience_id" => $oExp->id,
                    "category_id" => $category
                ];
            }
        }
        DB::table('experience_categories')->where('experience_id', '=', $id)->delete();
        ExperienceCategories::insert($aCats);


        DB::table('experience_prices')->where('experience_id', '=', $id)->delete();
        if(isset($all["prices"])){
            foreach($all["prices"] as $aP){
                $min = $aP["min"];
                $max = $aP["max"];
                $price = $aP["price"];
                $type = $aP["type"];
                $price_type = $aP["price_type"];

                if(!($min && $max && $price && $type && $price_type)) continue;

                $aPrices = [
                    "experience_id" =>  $oExp->id,
                    "min"           =>  $min,
                    "max"           =>  $max,
                    "price"         =>  $price,
                    "price_type"    =>  $price_type,
                    "type"          =>  $type
                ];
                ExperiencePrices::insert($aPrices);
            }
        }

        $message = 'Experience updated successfully';

        $oExp->title = $all['title'];
        $oExp->description = $all['description'];
        $oExp->child_friendly = $all["child_friendly"];
        $oExp->duration = $all["duration"];
        $oExp->duration_unit = $all["duration_unit"];
        $oExp->disabled_friendly = $all["disabled_friendly"];
        $oExp->availability = isset($all["availability"]) ? $all["availability"] : [];
        $oExp->transportation = isset($all["transportation"]) ? $all["transportation"] : 0;
        $oExp->accommodation = isset($all["accommodation"]) ? $all["accommodation"] : 0;
        $oExp->cancellation_policy = isset($all["cancellation_policy"]) ? $all["cancellation_policy"] : "";
        $oExp->purchase_note = isset($all["purchase_note"]) ? $all["purchase_note"] : "";
        $oExp->save();



        if(isset($all["language"])) {
            $aLang = [];
            foreach ($all["language"] as $lang) {
                if($lang) {
                    $aLang[] = [
                        "experience_id" => $oExp->id,
                        "language_id" => $lang
                    ];
                }
            }
            DB::table('experience_languages')->where('experience_id', '=', $id)->delete();
            ExperienceLanguage::insert($aLang);
        }


        if(isset($all["resources"])){
            $aRes = [];
            foreach($all["resources"] as $res){
                $title = $res["title"];
                $price = $res["price"];
                    $aRes[] = [
                        "experience_id" => $all["id"],
                        "title" =>  $title,
                        "cost" =>  $price
                    ];

            }
            DB::table('experience_resources')->where('experience_id', '=', $id)->delete();
            ExperienceResources::insert($aRes);
        }

        $oExpAdmin = ExperienceAdmin::where('experience_id', '=', $id)->where('user_id', '=', $oExp->admin()->id)->first();
        $oExpAdmin->user_id = $all["owner"];
        $oExpAdmin->save();


        if (array_key_exists("publish", $all)) {
            $oExp->status = "pending";
            $message = "Experience has been submitted successfully. We will be in touch";
            $oExp->save();
            return redirect('/my-account')
                ->with('success', $message);
        }else if (array_key_exists("publish_admin", $all)) {
            if(Auth::user()->hasRole(["super_admin","admin"])){
                $oExp->save();
                $oExp = $oExp->makeLive();
                return redirect('/experience/'.$oExp->slug);
            }
        }

        return redirect('/experience/' . $oExp->id . '/edit')
            ->with('success', $message);
    }

    public function images($id){
        $oExp = OfflineExperience::find($id);
        foreach($oExp->images() as $oImg){ //get an array which has the names of all the files and loop through it
            $image = $oImg->image_file;
            $aName = explode('/',$image);
            $obj['fullpath'] = "/".$image; //get the filename in array
            $obj['name'] = end($aName);
            $obj['size'] = filesize(public_path()."/".$oImg->image_file); //get the flesize in array
            $images[] = $obj; // copy it to another array
        }
        return view('experience.images',compact('oExp','images'));
    }

    public function imagesUpload(Request $request){
        $photo = Input::all();
        $response = $this->image->upload($photo);
        return $response;
    }

    public function imagesDelete(Request $request){
        $filepath = $request->get('filepath');
        $experience_id = $request->get("experience_id");
        if(!$filepath || !$experience_id)
        {
            return 0;
        }

        $response = $this->image->delete( $filepath,$experience_id );

        return $response;
    }

    public function uploadFeatured(Request $request)
    {
        $oExp = OfflineExperience::find($request->input('eid'));
        if( $request->hasFile('featured') ) {
            $file = $request->file('featured');
            if(!File::exists("images/uploads/".date("Y"))){
                File::makeDirectory("images/uploads/".date("Y"));
            }
            if(!File::exists("images/uploads/".date("Y")."/".date("m"))){
                File::makeDirectory("images/uploads/".date("Y")."/".date("m"));
            }
            $aName = explode(".",$file->getClientOriginalName());
            unset($aName[count($aName) - 1]);

            $filename = implode('.', $aName);
            $filename = Functions::uniqueFilename("images/uploads/".date("Y")."/".date("m"),$filename,$file->getClientOriginalExtension());


            $file->move("images/uploads/".date("Y")."/".date("m"),$filename);

            $img = Image::make("images/uploads/".date("Y")."/".date("m")."/".$filename);
            $img->fit(600, 400);
            $img->save("images/uploads/".date("Y")."/".date("m")."/".$filename);

            $oExp->setThumbnail("images/uploads/".date("Y")."/".date("m")."/".$filename);
        }
        foreach($oExp->images() as $oImg){ //get an array which has the names of all the files and loop through it
            $image = $oImg->image_file;
            $aName = explode('/',$image);
            $obj['fullpath'] = $image; //get the filename in array
            $obj['name'] = end($aName);
            $obj['size'] = filesize(public_path()."/".$oImg->image_file); //get the flesize in array
            $images[] = $obj; // copy it to another array
        }
        return redirect("/experience/".$oExp->id."/edit/images");
    }

    public function makeFeatured(Request $request){

        $oExp = OfflineExperience::find($request->get("experience_id"));
        $image_file = $request->get('filepath');
        $image_file= ltrim($image_file,"/");
        $oExp->setThumbnail($image_file,false);
        return Response::json([
            'error' => false,
            'message' => 'done',
            'code' => 200
        ], 200);
    }

    public function uploadCroppedFeatured(Request $request)
    {
        $filename = public_path().$_POST['filepath'];
        $img = $_POST['jpgimageData'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        file_put_contents($filename, $data);
        return Response::json([
            'error' => false,
            'message' => 'done',
            'code' => 200
        ], 200);
    }

    public function accept($id,Request $request){
        $status = $request->input('status');
        $oExp = OfflineExperience::find($id);
        $oExp->makeLive();

        return redirect(route("experience.manage",compact('status')))
            ->with('success','It\'s alive!');
    }
}

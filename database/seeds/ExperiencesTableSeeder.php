<?php

use Illuminate\Database\Seeder;
use App\UserProfile;
use App\Functions;
use App\Index;
use Illuminate\Support\Facades\File;
use App\Experience;
use App\ExperienceAdmin;
use App\ExperienceImages;
use App\ExperienceCategories;

use App\ExperienceLanguage;
use App\ExperienceCountry;
use App\OfflineExperience;

class ExperiencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Eloquent::unguard();

        $aEcat = [];
        $aVen = [];
        $aTh = [];
        $aIm = [];
        $aAllImages = [];
        $aFriendly = [];
        $aTransport = [];
        $aAccommod = [];
        $aCountries = [];
        $aLanguages = [];
        $aAvailability = [];
        $aTransportType = [
            "242" => 1,
            "244" => 2,
            "241" => 3
        ];
        $aAccommodType = [
            "239" => 1,
            "240" => 3
        ];

        $eavail = 'exports/experience_availability.csv';
        $eavail_file = fopen($eavail, 'r');
        while (($line = fgetcsv($eavail_file)) !== FALSE) {
            $data = Functions::maybe_unserialize($line[1]);
            $tmp_ok = [];
            $tmp_notok = [];
            foreach ($data as $avail) {
                if ($avail["type"] == "days") {
                    $from = $avail["from"];
                    $to = $avail["to"];
                    $duration = ($from <= $to) ? ($to - $from) + 1 : ((7 - $from) + 1) + $to;
                    for ($i = 0; $i < $duration; $i++) {
                        if ($avail["bookable"] == "yes") {
                            $tmp_ok[] = $from;
                        } else {
                            $tmp_notok[] = $from;
                        }
                        $from++;
                        if ($from > 7) $from = 1;
                    }
                }
            }
            if(!count($tmp_ok)){
                $tmp_ok = [1,2,3,4,5,6,7];
            }
            $int = array_intersect($tmp_notok, $tmp_ok);
            if (count($int)) {
                foreach ($tmp_notok as $key => $value) {
                    $arr_key = array_search($value, $tmp_ok);
                    unset($tmp_ok[$arr_key]);
                }
                $tmp_ok = array_values($tmp_ok);
            }
            $aAvailability[$line[0]] = $tmp_ok;
        }


        $efriendlies = 'exports/experience_friendlies.csv';
        $efriendlies_file = fopen($efriendlies, 'r');
        while (($line = fgetcsv($efriendlies_file)) !== FALSE) {
            $f = $line[1] == "125" ? "child_friendly" : "disabled_friendly";
            $aFriendly[$line[0]][$f] = 1;
        }
        $etransport = 'exports/experience_transportation.csv';
        $etransport_file = fopen($etransport, 'r');
        while (($line = fgetcsv($etransport_file)) !== FALSE) {
            $f = $aTransportType[$line[1]];
            $aTransport[$line[0]] = $f;
        }

        $eaccomod = 'exports/experience_accommodation.csv';
        $eaccomod_file = fopen($eaccomod, 'r');
        while (($line = fgetcsv($eaccomod_file)) !== FALSE) {
            $f = $aAccommodType[$line[1]];
            $aAccommod[$line[0]] = $f;
        }


        $ecategories = 'exports/experience_categories.csv';
        $ecategories_file = fopen($ecategories, 'r');
        while (($line = fgetcsv($ecategories_file)) !== FALSE) {
            $aEcat[$line[0]] = explode(",",$line[1]);
        }

        $evendors = 'exports/experience_vendors.csv';
        $evendors_file = fopen($evendors, 'r');
        while (($line = fgetcsv($evendors_file)) !== FALSE) {
            $aVen[$line[0]] = $line[1];
        }

        $all_images = 'exports/all_images.csv';
        $all_images_file = fopen($all_images, 'r');
        while (($line = fgetcsv($all_images_file)) !== FALSE) {
            $aAllImages[$line[0]] = $line[1];
        }

        $ethumbnails = 'exports/experience_thumbnails.csv';
        $ethumbnails_file = fopen($ethumbnails, 'r');
        while (($line = fgetcsv($ethumbnails_file)) !== FALSE) {
            if(isset($aAllImages[$line[1]])) {
                $aTh[$line[0]] = $aAllImages[$line[1]];
            }
        }



        $eimages = 'exports/experience_images.csv';
        $eimages_file = fopen($eimages, 'r');
        while (($line = fgetcsv($eimages_file)) !== FALSE) {
            $aLine = explode(',',$line[1]);
            foreach ($aLine as $id) {
                if(isset($aAllImages[$id])) {
                    $aIm[$line[0]][] = $aAllImages[$id];
                }
            }
        }


        $eCounLang = 'exports/experience_country_and_languages.csv';
        $eCounLang_file = fopen($eCounLang,'r');
        while (($line = fgetcsv($eCounLang_file)) !== FALSE) {
            if($line[1] == "pa_country"){
                $aCountries[$line[0]][] = $line[2];
            }else if($line[1] == "pa_languages"){
                $aLanguages[$line[0]][] = $line[2];
            }
        }

        $experiences = 'exports/experiences.csv';
        $experiences_file = fopen($experiences, 'r');
        while (($line = fgetcsv($experiences_file)) !== FALSE) {
            $categories = isset($aEcat[$line[0]]) ? $aEcat[$line[0]] : [];
            $vdata = isset($aVen[$line[0]]) ? $aVen[$line[0]] : "";
            $aVdata = Functions::maybe_unserialize($vdata);

            $admins = isset($aVdata["admins"]) ? explode(",",$aVdata["admins"]) : [];

            foreach ($categories as $cat) {
                ExperienceCategories::create([
                    "experience_id" => $line[0],
                    "category_id" => $cat
                ]);
            }

            if (isset($aIm[$line[0]])) {
                foreach ($aIm[$line[0]] as $key=>$im) {
                    if(File::exists(public_path()."/images/uploads/" . utf8_encode($im))) {
                        ExperienceImages::updateOrCreate([
                            "experience_id" => $line[0],
                            "image_file" => "images/uploads/" . $im,
                            "icon_file" => "",
                            "thumbnail" => 0
                        ]);
                    }else{
                        unset($aIm[$line[0]][$key]);
                    }
                }
            }
            if (isset($aTh[$line[0]]) && File::exists(public_path()."/images/uploads/" . utf8_encode($aTh[$line[0]]))) {


                ExperienceImages::updateOrCreate([
                    "experience_id" => $line[0],
                    "image_file" => "images/uploads/" . $aTh[$line[0]],
                    "icon_file" => ""
                ], ["thumbnail" => 1]);
            }else if(isset($aIm[$line[0]][0])){
                ExperienceImages::updateOrCreate([
                    "experience_id" => $line[0],
                    "image_file" => "images/uploads/" . $aIm[$line[0]][0],
                    "icon_file" => ""
                ], ["thumbnail" => 1]);
            }

            if (isset($aCountries[$line[0]])) {
                foreach ($aCountries[$line[0]] as $country) {
                    ExperienceCountry::create([
                        "experience_id" => $line[0],
                        "country_id" => $country
                    ]);
                }
            }

            if (isset($aLanguages[$line[0]])) {
                foreach ($aLanguages[$line[0]] as $language) {
                    ExperienceLanguage::create([
                        "experience_id" => $line[0],
                        "language_id" => $language
                    ]);
                }
            }


            $noadmins = true;
            foreach($admins as $key=>$admin){
                if(!$admin){
                    continue;
                }
                $noadmins = false;
                ExperienceAdmin::create([
                    "experience_id" => $line[0],
                    "user_id" => $admin,
                    "main" => ($key==0 ? 1 : 0)
                ]);
                UserProfile::updateOrCreate(
                    ["user_id" => $admin],
                    ["logo" => isset($aVdata["logo"]) && isset($aAllImages[$aVdata["logo"]]) ? "images/uploads/".$aAllImages[$aVdata["logo"]] : "",
                        "profile" => isset($aVdata["profile"]) ? $aVdata["profile"] : "",
                        "notes" => isset($aVdata["notes"]) ? $aVdata["notes"] : "",
                        "paypal" => isset($aVdata["paypal"]) ? $aVdata["paypal"] : ""]
                );
            }
            if($noadmins){
                ExperienceAdmin::create([
                    "experience_id" => $line[0],
                    "user_id" => $line[1],
                    "main" => 1
                ]);
            }


            if($line[4] == "publish") {
                Experience::create([
                    "id" => $line[0],
                    "sku" => uniqid(),
                    "user_id" => $line[1],
                    "title" => $line[2],
                    "description" => Functions::nl2br_special($line[3]),
                    "slug" => $line[5],
                    "menu_order" => $line[6],
                    "child_friendly" => isset($aFriendly[$line[0]]['child_friendly']) ? 1 : 0,
                    "disabled_friendly" => isset($aFriendly[$line[0]]['disabled_friendly']) ? 1 : 0,
                    "availability"=> isset($aAvailability[$line[0]]) ? json_encode($aAvailability[$line[0]]) : json_encode([1,2,3,4,5,6,7]),
                    "transportation" => isset($aTransport[$line[0]]) ? $aTransport[$line[0]] : 0,
                    "accommodation" => isset($aAccommod[$line[0]]) ? $aAccommod[$line[0]] : 0,
                    "purchase_note" => "",
                    "cancellation_policy" =>  "",
                    "duration"  =>0,
                    "duration_unit"  => "",
                    "created_at" => $line[7],
                    "updated_at" => $line[8]
                ]);
            }else{
                OfflineExperience::create([
                    "id" => $line[0],
                    "sku" => uniqid(),
                    "user_id" => $line[1],
                    "title" => $line[2],
                    "description" => Functions::nl2br_special($line[3]),
                    "status" => $line[4],
                    "slug" => $line[5],
                    "menu_order" => $line[6],
                    "child_friendly" => isset($aFriendly[$line[0]]['child_friendly']) ? 1 : 0,
                    "disabled_friendly" => isset($aFriendly[$line[0]]['disabled_friendly']) ? 1 : 0,
                    "availability"=> isset($aAvailability[$line[0]]) ? implode(",",$aAvailability[$line[0]]) : "1,2,3,4,5,6,7",
                    "transportation" => isset($aTransport[$line[0]]) ? $aTransport[$line[0]] : 0,
                    "accommodation" => isset($aAccommod[$line[0]]) ? $aAccommod[$line[0]] : 0,
                    "purchase_note" => "",
                    "cancellation_policy" =>  "",
                    "duration"  =>0,
                    "duration_unit"  => "",
                    "created_at" => $line[7],
                    "updated_at" => $line[8]
                ]);
            }

            Index::whereTable("experience")->first()->updateIndex($line[0]);

        }


        fclose($ecategories_file);
        fclose($evendors_file);
        fclose($experiences_file);
        fclose($ethumbnails_file);
        fclose($eimages_file);
        fclose($all_images_file);
        fclose($eCounLang_file);
        fclose($eavail_file);
    }
}

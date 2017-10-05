<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\Language;

class LanguageAndCountryTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $abbr = [
        "english"   =>  "gb", "turkish"   =>  "tr", "french"    =>  "fr", "german"=>"de", "spanish"=>"es", "russian"=>"ru", "persian"=>"fa",
        "dutch"=>"nl", "greek"=>"el", "albanian"=>"sq", "polish"=>"pl", "hungarian"=>"hu", "arabic"=>"ar", "romanian"=>"ro", "azerbaijani"=>"az",
        "bulgarian"=>"bg", "armanian"=>"hy", "italian"=>"it", "herbew"=>"he", "portuguese"=>"pt", "chinese"=>"zh", "standard-chinese"=>"zh",
        "czech"=>"cs","slovak"=>"sk","danish"=>"da","norwegian"=>"nn","swedish"=>"sv","japanese"=>"ja","hindi"=>"hi","javanese"=>"jv","bengali"=>"bn",
        "vietnamese"=>"vi","urdu"=>"ur","ukrainian"=>"uk","turkmen"=>"tk","kazakh"=>"kk","kurdish"=>"ku"
    ];

    public function run()
    {
        $eCounLang = 'exports/language_and_countries.csv';
        $eCounLang_file = fopen($eCounLang, 'r');
        while (($line = fgetcsv($eCounLang_file)) !== FALSE) {
            if($line[1] == "pa_country"){
                Country::create([
                    "id"    => $line[0],
                    "name"  => $line[3],
                    "slug"  => $line[4],
                    "parent"=> $line[2]
                ]);
            }else if($line[1] == "pa_languages"){
                Language::create([
                    "id"    => $line[0],
                    "name"  => $line[3],
                    "slug"  => $line[4],
                    "abbreviation" => isset($this->abbr[$line[4]]) ? $this->abbr[$line[4]] : ""
                ]);
            }
        }
    }
}
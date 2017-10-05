<?php

use Illuminate\Database\Seeder;
use App\ExperiencePrices;
use App\ExperienceResources;
use App\Functions;
use App\Experience;
use App\OfflineExperience;

class ExperiencePricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aResources = [];


        $eresources = 'exports/resources.csv';
        $eresources_file = fopen($eresources, 'r');
        while (($line = fgetcsv($eresources_file)) !== FALSE) {
            $aResources[$line[0]] = $line[1];
        }

        $pricing = 'exports/experience_pricing.csv';
        $pricing_file = fopen($pricing, 'r');
        while (($line = fgetcsv($pricing_file)) !== FALSE) {
            $aAllPricing = [];
            $resources = [];

            $tmp_resources = $line[10] !== NULL ? Functions::maybe_unserialize($line[10]) : [];
            if(is_array($tmp_resources)) {
                foreach ($tmp_resources as $res => $res_price) {
                    if (!isset($aResources[$res])) continue;
                    $resources[] = [
                        "experience_id" => $line[0],
                        "title" => $aResources[$res],
                        "cost" => $res_price ?: 0
                    ];
                }
            }


            $purchase_note = $line[8] ? Functions::maybe_unserialize($line[8]) : "";
            $purchase_note = is_array($purchase_note) ? "" : $purchase_note;
            $duration = $line[4];
            $duration_unit = $line[5];


            $tmp_models = $line[9] ? Functions::maybe_unserialize($line[9]) : [];




            if(is_array($tmp_models) && count($tmp_models)){
                $tmp = [];
                for($i=$line[6];$i<=$line[7];$i++){
                    $tmp[$i] = null;
                }
                foreach($tmp_models as $model) {
                    for ($j = $model["from"]; $j <= $model["to"]; $j++){
                        $aAllPricing[] = [
                            "experience_id" => $line[0],
                            "min" => $model["from"] ?: 0,
                            "max" => $model["to"] ?: 0,
                            "price_type" => "total",
                            "type"  =>  "adults",
                            "price" => $line[2]+$model["base_cost"],

                        ];
                        unset($tmp[$j]);
                    }
                }

                $previous = null;
                $min = null;
                $max = null;
                $keys = array_keys($tmp);

                if(count($keys)==1){
                    $from = array_keys($tmp)[0];
                    $to = $from;

                    $aAllPricing[] = [
                        "experience_id" => $line[0],
                        "min" => $from ?: 0,
                        "max" => $to ?:0,
                        "price_type" => "persons",
                        "type"  =>  "adults",
                        "price" => $line[2],
                    ];
                }else {

                    foreach ($keys as $key=>$current) {
                        if (is_null($previous)) {
                            $min = $current;
                        }else if($current != ($previous + 1)) {
                            $max = $previous;
                            $previous = null;
                        }else if($key == count($keys)-1){
                            $max = $current;
                            $previous = null;
                        }
                        if ($min && $max) {

                            $aAllPricing[] = [
                                "experience_id" => $line[0],
                                "min" => $min,
                                "max" => $max,
                                "price_type" => "persons",
                                "type"  =>  "adults",
                                "price" => $line[2],

                            ];

                            $min = null;
                            $max = null;
                        }

                        $previous = $current;
                    }
                }


            }else{
                $aAllPricing[] = [
                    "experience_id" => $line[0],
                    "min"   =>  $line[6] ?: 0,
                    "max"   =>  $line[7] ?: 0,
                    "price_type" => "persons",
                    "type"  =>  "adults",
                    "price" =>  $line[2]
                ];
            }



            $oExp = Experience::find($line[0]);
            if(!$oExp){
                $oExp = OfflineExperience::find($line[0]);
            }
            if($oExp){
                $oExp->duration = $duration;
                $oExp->duration_unit = $duration_unit;
                $oExp->purchase_note = $purchase_note;
            }
            ExperiencePrices::insert($aAllPricing);
            ExperienceResources::insert($resources);


/*
            if(is_array($tmp_models)) {
                foreach ($tmp_models as $mod) {
                    if(($mod["cost"] OR $mod["base_cost"]) && $mod["to"] && $mod["from"]) {
                        $aPriceModel[] = [
                            "experience_id" => $line[0],
                            "min" => $mod["from"],
                            "max" => $mod["to"],
                            "type" => "adults",
                            "price" => ($mod["cost"] ? $mod["cost"] : $mod["base_cost"])
                        ];
                    }
                }
            }
            $aAllPricing[$line[0]] = [
                "experience_id" => $line[0],
                "duration"      => $duration,
                "duration_unit" => $duration_unit,
                "purchase_note" => $purchase_note,
                "resources"     => $resources,
                "price_models"  => $aPriceModel
            ];
*/
        }
        /*
        if (isset($aAllPricing[$line[0]])){
            $prices = $aAllPricing[$line[0]]["price_models"];
            $resources = $aAllPricing[$line[0]]["resources"];
            unset($aAllPricing[$line[0]]["price_models"]);
            unset($aAllPricing[$line[0]]["resources"]);

            $experience_meta = $aAllPricing[$line[0]];
            foreach($prices as $aPrice){
                ExperiencePrices::create($aPrice);
            }
            foreach ($resources as $res) {
                ExperienceResources::create($res);
            }
        }*/


        fclose($pricing_file);


        fclose($eresources_file);


    }
}

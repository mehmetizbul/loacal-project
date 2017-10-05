<?php

namespace App;
use App\Messenger\Models\Message;
use App\Messenger\Models\Models;
use App\Messenger\Models\Participant;
use App\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    protected $fillable = [
        "user_id",
        "sku",
        "number_adults",
        "number_children",
        "price_adults",
        "price_children",
        "dates",
        "extras",
        "price_extras",
        "accommodation",
        "transportation",
        "accepted_by_customer",
        "accepted_by_vendor",
        "closed"
    ];

    /**
     * Experience relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @codeCoverageIgnore
     */
    public function experience()
    {
        $oExp = $this->hasOne("App\Experience", 'sku', 'sku')->first();
        if(!$oExp) $oExp = $this->hasOne("App\OfflineExperience", 'sku', 'sku')->first();
        return $oExp;
    }

    public function requests(){
        return $this->belongsTo("App\Messenger\Models\Thread", 'booking_request', 'id')->where;
    }

    public function aDates(){
        return json_decode($this->getAttribute("dates"));
    }

    public function aExtras(){
        $extras  = json_decode($this->getAttribute("extras"));
        $ret = [];
        if(is_array($extras) && count($extras)) {
            foreach ($extras as $e) {
                $ret[] = ExperienceResources::find($e);
            }
        }
        return $ret;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function accept(){
        $this->attributes["accepted"] = 1;
        $this->save();
    }

    public function deaccept(){
        $this->attributes["accepted"] = 0;
        $this->save();
    }

    public function close(){
        $this->attributes["closed"] = 1;
        $this->save();
    }

    public function total(){
        $total = 0;
        $total += ($this->price_adults)+($this->price_children)+($this->price_extras);
        return number_format(round($total * 2, 0)/2, 2, '.', '');
    }




}

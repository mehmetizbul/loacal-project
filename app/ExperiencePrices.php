<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperiencePrices extends Model
{
    protected $fillable = [
        "experience_id","min","max","type","price_type","price"
    ];
}

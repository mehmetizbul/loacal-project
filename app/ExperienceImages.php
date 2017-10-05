<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienceImages extends Model
{
    protected $fillable = ['experience_id', 'image_file', 'icon_file','thumbnail'];
}

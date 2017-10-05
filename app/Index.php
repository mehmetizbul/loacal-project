<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    protected $fillable=["value"];

    public function updateIndex($value=null){
        if($value<=$this->value) return false;
        if($value){
            $this->value = $value;
        }else{
            $this->value++;
        }
        $this->save();
        return $this->value;
    }

    public function newIndex(){
        $new = $this->value;
        $new++;
        return $new;
    }
}

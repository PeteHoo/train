<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
	
    protected $table = 'special';

    public function occupation(){
        return $this->hasOne('App\Models\Occupation','id','occupation_id');
    }
}

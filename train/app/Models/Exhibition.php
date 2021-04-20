<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{

    protected $table = 'exhibition';

    public function occupation(){
        return $this->hasOne('App\Models\Occupation','id','occupation_id');
    }

    public function material(){
        return $this->hasOne('App\Models\LearningMaterial','id','material_id');
    }
}

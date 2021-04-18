<?php

namespace App\Models;


use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{

    protected $table = 'learning_materials';

    public static function getLearningMaterialData(){
        return self::where('status',Constants::OPEN)
            ->orderBy('sort','DESC')
            ->pluck('title','id');
    }

    public static function getLearningMaterialDataDetail($id){
        return self::where('id',$id)
                ->first()->title??'';
    }

    public function mechanism(){
        return $this->hasOne('App\Models\Mechanism','id','mechanism_id');
    }

    public function industry(){
        return $this->hasOne('App\Models\Industry','id','industry_id');
    }

    public function occupation(){
        return $this->hasOne('App\Models\Occupation','id','occupation_id');
    }
}

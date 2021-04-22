<?php

namespace App\Models;


use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{

    protected $table = 'learning_materials';

    public static function getLearningMaterialData($mechanism_id=0){
        $query=self::where('status',Constants::OPEN)
            ->orderBy('sort','DESC');
        if($mechanism_id){
            $query->where('mechanism_id',$mechanism_id);
        }
        return $query->pluck('title','id');
    }

    public static function getLearningMaterialIds($mechanism_id=0){
        $query=self::where('status',Constants::OPEN)
            ->orderBy('sort','DESC');
        if($mechanism_id){
            $query->where('mechanism_id',$mechanism_id);
        }
        return $query->pluck('id');
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

    public function chapter(){
        return $this->hasMany('App\Models\LearningMaterialChapter','learning_material_id','id')->where('status',Constants::OPEN)->with('learningMaterialDetail');
    }
}

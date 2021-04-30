<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LearningMaterialRecord extends Model
{

    protected $table = 'learning_material_record';
    protected $fillable=[
        'learning_material_detail_id',
        'user_id',
    ];

    public function learningMaterialDetail(){
        return $this->hasOne('App\Models\LearningMaterialDetail','id','learning_material_detail_id')->with('learningMaterial')->with('learningMaterialChapter');
    }
}

<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LearningMaterialDetail extends Model
{
	
    protected $table = 'learning_material_details';

    public function learningMaterial(){
        return $this->hasOne('App\Models\LearningMaterial','id','learning_material_id');
    }
    public function learningMaterialChapter(){
        return $this->hasOne('App\Models\LearningMaterialChapter','id','chapter_id');
    }
}

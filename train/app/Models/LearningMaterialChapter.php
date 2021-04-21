<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LearningMaterialChapter extends Model
{
	
    protected $table = 'learning_material_chapters';

    public static function getLearningMaterialChapterData(){
        return self::orderBy('sort','DESC')->pluck('title','id');
    }

    public static function getLearningMaterialChapterDataDetail($id){
        return self::where('id',$id)
                ->first()->title??'';
    }
}

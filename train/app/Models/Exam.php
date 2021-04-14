<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
	
    protected $table = 'exam';

    public function examDetail(){
        return $this->hasMany('App\Models\ExamDetail','exam_id','id');
    }
    
}

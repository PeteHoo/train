<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{

    protected $table = 'exam';

    public function examDetail(){
        return $this->hasMany('App\Models\ExamDetail','exam_id','id')->select('question_id')->with('question');
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

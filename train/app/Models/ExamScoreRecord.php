<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ExamScoreRecord extends Model
{

    protected $table = 'exam_score_record';
    protected $fillable=[
        'user_id',
        'exam_id',
        'score',
        'question_count'
    ];
    public function appUser(){
        return $this->hasOne('App\Models\AppUser','user_id','user_id');
    }
}

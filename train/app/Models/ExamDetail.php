<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ExamDetail extends Model
{
	
    protected $table = 'exam_detail';

    public function question(){
        return $this->hasOne('App\Models\TestQuestion','id','question_id');
    }
    
}

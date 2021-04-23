<?php

namespace App\Models;


use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{

    protected $table = 'test_questions';

    protected $appends = ['answer_option'];

    public function getAnswerOptionAttribute(){
        if($this->attributes['type']==Constants::SINGLE_CHOICE){
            return json_decode($this->attributes['answer_single_option']);
        }elseif($this->attributes['type']==Constants::JUDGMENT){
            return json_decode($this->attributes['answer_judgment_option']);
        }
    }

}

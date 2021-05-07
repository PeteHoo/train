<?php

namespace App\Models;


use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{

    protected $table = 'test_questions';

    protected $appends = ['answer_option','description_image_json'];

    public function getAnswerOptionAttribute(){
        if($this->attributes['type']==Constants::SINGLE_CHOICE){
            $answer_single=u2c($this->attributes['answer_single_option']);
            $answer_single=str_replace('选项','answer',$answer_single);
            $answer_single=str_replace('答案','option',$answer_single);
            return json_decode($answer_single);
        }elseif($this->attributes['type']==Constants::JUDGMENT){
            $answer_judgment=u2c($this->attributes['answer_judgment_option']);
            $answer_judgment=str_replace('选项','answer',$answer_judgment);
            $answer_judgment=str_replace('答案','option',$answer_judgment);
            return json_decode($answer_judgment);
        }
    }

    public function getDescriptionImageJsonAttribute(){
        $data=json_decode($this->attributes['description_image']);
        if($data){
            foreach ($data as $k=>$v){
                $data[$k]=getImageUrl($v);
            }
        }
        return $data;
    }

}

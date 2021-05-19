<?php

namespace App\Models;


use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{

    protected $table = 'test_questions';

    protected $fillable=[
        'type',
        'description',
        'description_image',
        'answer_single_option',
        'answer_judgment_option',
        'true_single_answer',
        'true_judgment_answer',
        'mechanism_id',
        'occupation_id',
        'created_at',
        'updated_at',
    ];

    protected $appends = ['answer_option','description_image_json'];

    public function getAnswerOptionAttribute(){
        if($this->attributes['type']==Constants::SINGLE_CHOICE){
            $answer_single_option=json_decode($this->attributes['answer_single_option'],true);
            $data=array();
            foreach ($answer_single_option as $k=>$v){
                $da['option']=$k;
                $da['answer']=$v;
                $data[]=$da;
            }
            return $data;
        }elseif($this->attributes['type']==Constants::JUDGMENT){
            $data[0]['option']='正确';
            $data[0]['answer']='正确';
            $data[1]['option']='错误';
            $data[1]['answer']='错误';
            return $data;
        }
    }

    public function getDescriptionImageJsonAttribute(){
        $data=json_decode($this->attributes['description_image'],true);
        if($data){
            foreach ($data as $k=>$v){
                $data[$k]=getImageUrl($v);
            }
        }
        return $data;
    }

}

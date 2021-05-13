<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\TestQuestion;
use App\Utils\Constants;

class DownloadController extends Controller
{
    public function testQuestionDownload(){
        return response()->download(public_path()."/excel/试题导入模板.xlsx");
    }

    public function changeExamOption(){
       $testList=TestQuestion::get();
        foreach ($testList as $k=>$v){
            try{
            if($v->type==Constants::SINGLE_CHOICE){
                    $answer_single_option=json_decode(($testList[$k]->answer_single_option),true);
                    $option['A']=$answer_single_option[0]['答案']??'';
                    $option['B']=$answer_single_option[1]['答案']??'';
                    $option['C']=$answer_single_option[2]['答案']??'';
                    $option['D']=$answer_single_option[3]['答案']??'';
                    $testList[$k]->answer_single_option=$option;
                }
                $testList[$k]->answer_judgment_option='';
                $testList[$k]->save();
            }catch (\Exception $e){
                continue;
            }

        }
    }
}

<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function testQuestionDownload(){
        return response()->download(public_path()."/excel/试题导入模板.xlsx");
    }
}

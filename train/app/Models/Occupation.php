<?php

namespace App\Models;


use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{

    protected $table = 'occupation';

    public static function getOccupationData(){
        return self::pluck('name','id');
    }

    public static function getOccupationIndustry(){
        $industryData=Industry::pluck('name','id');
        $belongData=self::pluck('industry_id','id');
        $occupationData=self::pluck('name','id');
        foreach ($occupationData as $k=>&$v){
            $occupationData[$k]=$industryData[$belongData[$k]].'-'.$v;
        }
        return $occupationData;
    }

    public static function getOccupationDataByIndustry_id($industry_id){
        return self::whereIn('industry_id',$industry_id)->pluck('name','id');
    }

    public static function getOccupationDataDetail($id){
        return self::where('id',$id)
                ->first()->name??'';
    }
}

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

    public static function getOccupationIndustry($json_occupation){
        $industryData=Industry::pluck('name','id');
        $belongData=self::pluck('industry_id','id');
        $query=self::select('id','name','industry_id');
        if($json_occupation=json_decode($json_occupation,true)){
            $query->whereIn('id',$json_occupation);
        }
        $occupationData=$query->get()->toArray();
        foreach ($occupationData as $k=>$v){
            $occupationData[$k]['industry']=$industryData[$belongData[$v['id']]];
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

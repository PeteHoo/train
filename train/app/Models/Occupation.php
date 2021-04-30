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

    public static function getOccupationDataByIndustry_id($industry_id){
        return self::whereIn('industry_id',$industry_id)->pluck('name','id');
    }

    public static function getOccupationDataDetail($id){
        return self::where('id',$id)
                ->first()->name??'';
    }
}

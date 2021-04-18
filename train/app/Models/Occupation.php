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

    public static function getOccupationDataByMechanism($mechanism_id){
        $industry=Industry::where('mechanism_id',$mechanism_id)->pluck('id');
        return self::whereIn('industry_id',$industry)->pluck('name','id');
    }

    public static function getOccupationDataDetail($id){
        return self::where('id',$id)
                ->first()->name??'';
    }
}

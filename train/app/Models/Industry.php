<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{

    protected $table = 'industry';

    public static function getIndustryData(){
        return self::where('status',1)
            ->orderBy('sort','DESC')
            ->pluck('name','id');
    }

    public static function getIndustryDataDetail($id){
        return self::where('id',$id)
            ->first()->name??'';
    }
}

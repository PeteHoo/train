<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Industry extends Model
{

    protected $table = 'industry';

    public static function getIndustryData($mechanism_id=0){
        $query=self::where('status',1)
            ->orderBy('sort','DESC');
        if($mechanism_id){
            $query->where('mechanism_id',$mechanism_id);
        }else{
            $query->where('mechanism_id',0);
        }
        return $query
            ->pluck('name','id');
    }

    public static function getIndustryDataDetail($id){
        return self::where('id',$id)
            ->first()->name??'';
    }

}

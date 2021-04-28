<?php

namespace App\Models;


use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Industry extends Model
{

    protected $table = 'industry';

    public static function getIndustryData(){
        $query=self::where('status',Constants::OPEN)
            ->orderBy('sort','DESC');
        return $query
            ->pluck('name','id');
    }

    public static function getIndustryDataDetail($id){
        return self::where('id',$id)
            ->first()->name??'';
    }

}

<?php

namespace App\Models;


use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{

    protected $table = 'occupation';

    public static function getOccupationData(){
        return self::where('status',Constants::OPEN)
            ->pluck('name','id');
    }

    public static function getOccupationDataDetail($id){
        return self::where('id',$id)
                ->first()->name??'';
    }
}

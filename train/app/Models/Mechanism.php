<?php

namespace App\Models;


use App\Utils\Constants;
use Illuminate\Database\Eloquent\Model;

class Mechanism extends Model
{

    protected $table = 'mechanism';

    public static function getMechanismData(){
        return self::where('status',Constants::OPEN)
            ->pluck('name','id');
    }

    public static function getMechanismDataDetail($id){
        return self::where('id',$id)
            ->first()->name??'';
    }
}

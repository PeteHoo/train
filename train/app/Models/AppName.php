<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AppName extends Model
{
	
    protected $table = 'app_name';

    public static function getAppNameData(){
        return self::pluck('name','id');
    }

    public static function getAppNameDetail($id){
        return self::find($id)->name??'';
    }

    public static function getAppKey($name){
        return self::where('name',$name)->first()->id??0;
    }
}

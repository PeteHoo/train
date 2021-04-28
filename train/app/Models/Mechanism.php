<?php

namespace App\Models;


use App\Utils\Constants;
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Model;

class Mechanism extends Model
{

    protected $table = 'admin_users';

    public static function getMechanismData($search_words=''){
        $query=self::where('status',Constants::OPEN);
        if($search_words){
            $query->where('name','like','%'.$search_words.'%');
        }
        return $query
            ->pluck('name','id')->toArray();
    }

    public static function getMechanismAppData($search_words=''){
        $query=self::where('status',Constants::OPEN);
        if($search_words){
            $query->where('name','like','%'.$search_words.'%');
        }
        return $query
            ->select('id','name')->get();
    }

    public static function getMechanismDataDetail($id){
        return self::find($id)->name??'平台';
    }
}

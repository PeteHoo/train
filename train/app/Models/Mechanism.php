<?php

namespace App\Models;


use App\Utils\Constants;
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Model;

class Mechanism extends Model
{

    protected $table = 'admin_users';

    public static function getMechanismData(){
        return self::where('status',Constants::OPEN)
            ->pluck('name','id')->toArray();
    }

    public static function getMechanismDataDetail($id){
        return self::find($id)->name??'平台';
    }
}

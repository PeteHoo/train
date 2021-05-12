<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Version extends Model
{

    protected $table = 'version';

    public static function getVersionData($app){
        return self::where('status',1)
            ->where('name',$app)
            ->pluck('version_code','id');
    }

    public static function getVersionDetail($id){
        return self::where('id',$id)
                ->first()->version_code??'';
    }

    public static function getVersionDetails($ids){
        if(!$ids){
            return '';
        }
        $data=self::whereIn('id',$ids)
                ->pluck('version_code')->toArray();
        return implode(',',$data);

    }

}

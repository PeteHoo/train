<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Version extends Model
{

    protected $table = 'version';

    public static function getVersionData($app){
        return self::where('status',1)
            ->where('name',$app)
            ->orderBy('sort','DESC')
            ->pluck('version_code','id');
    }
}

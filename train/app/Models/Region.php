<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'region';
    public static function getRegion($parentId = 0)
    {
        return self::where(['parent_id' => $parentId])->pluck('name','id');
    }
    public static function getRegionById($id = 0)
    {
        return self::find($id)->name;
    }
}

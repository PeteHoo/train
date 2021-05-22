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

    public static function getIndustryDataPaginate($start){
        $query=self::where('status',Constants::OPEN)
            ->orderBy('sort','DESC');
        return $query->paginate($start);
    }

    public static function getIndustryObject(){
        $query=self::where('status',Constants::OPEN)
            ->select('id','name')
            ->with(['occupation'=>function($q){
                $q->select('industry_id','id','name');
            }])
            ->orderBy('sort','DESC');
        return $query
            ->get();
    }

    public static function getIndustryDataDetail($id){
        return self::where('id',$id)
            ->first()->name??'';
    }

    public function occupation(){
       return $this->hasMany('App\Models\Occupation','industry_id','id');
    }

}

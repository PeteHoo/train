<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 15:52
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\LearningMaterialRequest;
use App\Http\Resources\LearningMaterialResource;
use App\Models\LearningMaterial;
use App\Utils\Constants;
use Illuminate\Support\Facades\Auth;

class LearningMaterialController extends ApiController
{
     public function materialList(LearningMaterialRequest $request){
         $query=LearningMaterial::where('occupation_id',$request->get('occupation_id'))
             ->where('status',Constants::OPEN)
             ->orderBy('sort', 'DESC')
             ->orderBy('created_at', 'DESC');
         if($occupation_id=Auth::user()->occupation_id){
             $query->where('occupation_id',$occupation_id);
         }
         return self::success(
             $query->paginate($request->get('perPage')));
     }

     public function materialDetail(LearningMaterialRequest $request){
         return self::success(new LearningMaterialResource(
             LearningMaterial::where('id',$request->input('id'))
             ->where('status',Constants::OPEN)->first()));
     }

     public function searchMaterial(LearningMaterialRequest $request){
            $search_word=$request->get('search_word');
           ;$query=LearningMaterial::where('status',Constants::OPEN)
             ->where(function ($where)use($search_word){
                return $where->where('description','like',$search_word)
                     ->orWhere(function ($where)use($search_word){
                         $where->whereHas('mechanism',function ($query)use($search_word){
                             $query->where('name', 'like', '%' . $search_word . '%');
                         });
                     })
                     ->orWhere(function ($where)use($search_word){
                         $where->whereHas('industry',function ($query)use($search_word){
                             $query->where('name', 'like', '%' . $search_word . '%');
                         });
                     })
                     ->orWhere(function ($where)use($search_word){
                         $where->whereHas('occupation',function ($query)use($search_word){
                             $query->where('name', 'like', '%' . $search_word . '%');
                         });
                     });
             });

             if($mechanism_id=Auth::user()->mechanism_id){
                 $query->where('mechanism_id',$mechanism_id);
             }
             if($industry_id=Auth::user()->industry_id){
                 $query->where('industry_id',$industry_id);
             }
             if($occupation_id=Auth::user()->occupation_id){
                  $query->where('occupation_id',$occupation_id);
             }
             return self::success($query->get());
     }

}
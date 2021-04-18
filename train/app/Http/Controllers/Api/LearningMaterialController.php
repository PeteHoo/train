<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 15:52
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\LearningMaterialRequest;
use App\Models\LearningMaterial;

class LearningMaterialController extends ApiController
{
     public function materialList(LearningMaterialRequest $request){
         LearningMaterial::where('occupation_id',$request->get('occupation_id'))->orderBy('sort', 'DESC')->orderBy('created_at', 'DESC')->paginate($request->get('perPage'));
     }
}
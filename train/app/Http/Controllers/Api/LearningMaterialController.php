<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 15:52
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\LearningMaterialRequest;
use App\Http\Resources\LearningMaterialCollectionPaginate;
use App\Http\Resources\LearningMaterialDetailResource;
use App\Http\Resources\LearningMaterialResource;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialRecord;
use App\Service\LearningMaterialService;
use App\Utils\Constants;
use App\Utils\ErrorCode;
use Illuminate\Support\Facades\Auth;
use PhpParser\Error;

class LearningMaterialController extends ApiController
{
    /** 视频列表
     * @param LearningMaterialRequest $request
     * @return string|null
     */
     public function materialList(LearningMaterialRequest $request){
         $query=LearningMaterial::where('status',Constants::OPEN)
             ->orderBy('sort', 'DESC')
             ->orderBy('created_at', 'DESC');
         if($occupation_id=json_decode(Auth::user()->occupation_id)){
             $query->whereIn('occupation_id',$occupation_id);
         }else{
             //如果没有绑定职业查询公共视频
             $query->where('occupation_id',0);
         }
         return self::success(new LearningMaterialCollectionPaginate($query->paginate($request->get('perPage'))
             ));
     }

    /** 视频详情
     * @param LearningMaterialRequest $request
     * @return string|null
     */
     public function materialDetail(LearningMaterialRequest $request){
         $id=$request->input('id');
         $learningMaterial=LearningMaterial::where('id',$id)
             ->where('status',Constants::OPEN)->first();
         return self::success(new LearningMaterialDetailResource($learningMaterial));
     }

    /** 推荐视频
     * @param LearningMaterialRequest $request
     * @return string|null
     */
     public function recommendMaterialList(LearningMaterialRequest $request){
         return self::success(LearningMaterialService::getRecommendData($request->get('id'),$request->get('occupation_id')));
     }

    /** 搜索视频
     * @param LearningMaterialRequest $request
     * @return string|null
     */
     public function searchMaterial(LearningMaterialRequest $request){
            $search_word=$request->get('search_word');
            $query=LearningMaterial::where('status',Constants::OPEN)
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
             if($industry_id=json_decode(Auth::user()->industry_id)){
                 $query->whereIn('industry_id',$industry_id);
             }
             if($occupation_id=json_decode(Auth::user()->occupation_id)){
                  $query->whereIn('occupation_id',$occupation_id);
             }
             return self::success(new LearningMaterialCollectionPaginate($query->paginate($request->get('perPage'))));
     }

    /** 上传学习记录
     * @param LearningMaterialRequest $request
     * @return string|null
     */
     public function learningMaterialRecord(LearningMaterialRequest $request){
         $data['learning_material_detail_id']=$request->post('learning_material_detail_id');
         $data['user_id']=Auth::user()->user_id;
         return LearningMaterialRecord::firstOrCreate($data)?self::success():self::error(ErrorCode::FAILURE);
     }

}

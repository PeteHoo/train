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
use App\Http\Resources\LearningMaterialRecordCollectionPaginate;
use App\Http\Resources\LearningMaterialRecordResource;
use App\Http\Resources\LearningMaterialResource;
use App\Models\HotSearch;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialDetail;
use App\Models\LearningMaterialRecord;
use App\Service\HotSearchService;
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
    public function materialList(LearningMaterialRequest $request)
    {
        $query = LearningMaterial::where('status', Constants::OPEN)
            ->orderBy('sort', 'DESC')
            ->orderBy('created_at', 'DESC');
        if ($occupation_id = $request->get('occupation_id')) {
            $query->where('occupation_id', $occupation_id);
        } else {
            if ($occupation_id = json_decode(Auth::user()->occupation_id)) {
                $query->whereIn('occupation_id', $occupation_id);
            } else {
                //如果没有绑定职业查询公共视频
                $query->where('occupation_id', 0);
            }
        }
        $query->where(function ($where) {
            return $where->where('is_open', Constants::OPEN)
                ->orWhere(function ($where) {
                    $where->where('is_open', Constants::CLOSE)
                        ->where('mechanism_id', Auth::user()->mechanism_id);
                });
        });
        return self::success(new LearningMaterialCollectionPaginate($query->paginate($request->get('per_page'))
        ));
    }

    /** 视频详情
     * @param LearningMaterialRequest $request
     * @return string|null
     */
    public function materialDetail(LearningMaterialRequest $request)
    {
        $id = $request->input('id');
        $learningMaterial = LearningMaterial::where('id', $id)
            ->where('status', Constants::OPEN)->where(function ($where) {
                return $where->where('is_open', Constants::OPEN)
                    ->orWhere(function ($where) {
                        $where->where('is_open', Constants::CLOSE)
                            ->where('mechanism_id', Auth::user()->mechanism_id);
                    });
            })
            ->first();
        if(!$learningMaterial){
            return self::error(ErrorCode::FAILURE,'不存在该视频详情');
        }
        $data = new LearningMaterialDetailResource($learningMaterial);
        $learningMaterialRecord = LearningMaterialRecord::where('user_id', Auth::user()->user_id)->pluck('learning_material_detail_id')->toArray();
        $learningMaterialRecord = array_unique($learningMaterialRecord);
        $learningMaterialRecord = array_values($learningMaterialRecord);
        //用户学过的课程
        $detail_count=0;
        if ($data) {
            foreach ($data->chapter as $k => &$v) {
                foreach ($v->learningMaterialDetail as $kk => &$vv) {
                    $vv->video=getImageUrl($vv->video);
                    $vv->duration=changeTimeType(get_duration_params($vv->video));
                    if (in_array($vv->id, $learningMaterialRecord)) {
                        $vv->is_study = 1;
                    } else {
                        $vv->is_study = 0;
                    }
                    $detail_count++;
                }
            }
        }
        $data=$data->toArray($request);
        $data['detail_count']=$detail_count;
        return self::success($data);
    }

    /** 推荐视频
     * @param LearningMaterialRequest $request
     * @return string|null
     */
    public function recommendMaterialList(LearningMaterialRequest $request)
    {
        return self::success(LearningMaterialService::getRecommendData($request->get('id'), $request->get('occupation_id'),Auth::user()->mechanism_id));
    }

    /** 搜索视频
     * @param LearningMaterialRequest $request
     * @return string|null
     */
    public function searchMaterial(LearningMaterialRequest $request)
    {
        $search_word = $request->get('search_word');
        //搜索增加次数
//        HotSearchService::addHotSearch($search_word);
        $query = LearningMaterial::where('status', Constants::OPEN)
            ->where(function ($where) use ($search_word) {
                return $where->where('description', 'like', $search_word)
                    ->orWhere(function ($where) use ($search_word) {
                        $where->whereHas('mechanism', function ($query) use ($search_word) {
                            $query->where('name', 'like', '%' . $search_word . '%');
                        });
                    })
                    ->orWhere(function ($where) use ($search_word) {
                        $where->whereHas('industry', function ($query) use ($search_word) {
                            $query->where('name', 'like', '%' . $search_word . '%');
                        });
                    })
                    ->orWhere(function ($where) use ($search_word) {
                        $where->whereHas('occupation', function ($query) use ($search_word) {
                            $query->where('name', 'like', '%' . $search_word . '%');
                        });
                    });
            });
//        ->where(function ($where) {
//        return $where->where('mechanism_id', 1)
//            ->orWhere(function ($where) {
//                $where->where('mechanism_id','>',1)
//                    ->where(function ($where){
//                        $where->where('is_open', Constants::CLOSE)
//                            ->where('mechanism_id', Auth::user()->mechanism_id);
//                    })
//                    ->orWhere('is_open',Constants::OPEN);
//
//            });
//    });
//        if ($industry_id = json_decode(Auth::user()->industry_id)) {
//            $query->whereIn('industry_id', $industry_id);
//        }
//        if ($occupation_id = json_decode(Auth::user()->occupation_id)) {
//            $query->whereIn('occupation_id', $occupation_id);
//        }
        return self::success(new LearningMaterialCollectionPaginate($query->paginate($request->get('per_page'))));
    }

    /** 上传学习记录
     * @param LearningMaterialRequest $request
     * @return string|null
     */
    public function learningMaterialRecord(LearningMaterialRequest $request)
    {
        $learning_material_detail_id = $request->post('learning_material_detail_id');
        if(!LearningMaterialDetail::where('id',$learning_material_detail_id)->first()){
            return self::error(ErrorCode::FAILURE,'不存在该课件');
        }
        $data['user_id'] = Auth::user()->user_id;
        $data['learning_material_detail_id']=$learning_material_detail_id;
        $append['duration']=timeToSecond($request->post('duration'));
        return LearningMaterialRecord::firstOrCreate($data,$append) ? self::success() : self::error(ErrorCode::FAILURE);
    }

    /** 删除学习记录
     * @param LearningMaterialRequest $request
     * @return string|null
     */
    public function learningMaterialDelete(LearningMaterialRequest $request)
    {
        if(!$ids=json_decode($request->post('ids'))){
           return self::error(ErrorCode::PARAMETER_ERROR,'ids格式错误');
        }
        return LearningMaterialRecord::whereIn('id',$ids)->where('user_id',Auth::user()->user_id)->update(['is_delete'=>1])?self::success():self::error(ErrorCode::FAILURE,'删除失败');
    }

    /** 学习记录
     * @param LearningMaterialRequest $request
     * @return null|string
     */
    public function learningMaterialRecordList(LearningMaterialRequest $request)
    {
        $data=LearningMaterialRecord::where('user_id', Auth::user()->user_id)->where('is_delete',0)->whereHas('learningMaterialDetail')->paginate($request->get('perPage'));
        return self::success(new LearningMaterialRecordCollectionPaginate($data));
    }


    /** 添加浏览次数
     * @param LearningMaterialRequest $request
     * @return null|string
     */
    public function addViewsCount(LearningMaterialRequest $request)
    {
        $detail_id = $request->post('detail_id');
        $learningMaterialDetail = LearningMaterialDetail::find($detail_id);
        if (!$learningMaterialDetail) {
            return self::error(ErrorCode::FAILURE, '不存在该学校资料');
        }
        $learningMaterialDetail->increment('view_count');
        $learningMaterial = LearningMaterial::find($learningMaterialDetail->learning_material_id);
        if ($learningMaterial) {
            $learningMaterial->increment('view_count');
        }
        return self::success();
    }

}

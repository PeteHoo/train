<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\BaseDataRequest;
use App\Http\Resources\ExhibitionResource;
use App\Http\Resources\SpecialResource;
use App\Http\Resources\UpdatePlanResource;
use App\Models\Agreement;
use App\Models\Exhibition;
use App\Models\HotSearch;
use App\Models\Industry;
use App\Models\Mechanism;
use App\Models\Occupation;
use App\Models\Special;
use App\Models\UpdatePlan;
use App\Models\Version;
use App\Utils\Constants;
use App\Utils\ErrorCode;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BaseDataController extends ApiController
{
    /** 机构列表
     * @param Request $request
     * @return string|null
     */
    public function mechanism(Request $request){
        $search_words=$request->get('search_words');
        return self::success(Mechanism::getMechanismAppData($search_words));
    }


    /** 行业数据
     * @return string|null
     */
    public function industry()
    {
       return self::success(Industry::getIndustryData());
    }

    /** 职业数据
     * @param Request $request
     * @return string|null
     */
    public function occupation(Request $request)
    {
        $industry=$request->get('industry_id');
        $industry=json_decode($industry);
        if(!$industry){
            return self::error(ErrorCode::PARAMETER_ERROR,'行业id必填');
        }
        return self::success(Occupation::getOccupationDataByIndustry_id($industry));
    }

    /** banner接口
     * @return null|string
     */
    public function banner(){
       return self::success(ExhibitionResource::collection(Exhibition::whereIn('occupation_id',json_decode(Auth::user()->occupation_id))
           ->where('status',Constants::OPEN)
           ->orderBy('sort','DESC')
           ->get()));
    }

    /**
     * @return null|string
     */
    public function special(){
        return self::success(SpecialResource::collection(Special::whereIn('occupation_id',json_decode(Auth::user()->occupation_id))
            ->where('status',Constants::OPEN)
            ->orderBy('sort','DESC')
            ->get()));
    }

    /** 热词列表
     * @return null|string
     */
    public function searchWordsList(){
        return self::success(HotSearch::where('status',Constants::OPEN)
            ->orderBy('sort','DESC')
            ->orderBy('count','DESC')
            ->get());
    }

    /** 检查版本
     * @param Request $request
     * @return string|null
     */
    public function checkVersion(BaseDataRequest $request){
         $os=$request->get('os');
         $name=Constants::getAppKey($request->get('name'));
         $version=Version::where('os',$os)->where('name',$name)->where('status',Constants::OPEN)->orderBy('created_at','DESC')->first();
         return self::success($version);
    }

    /** 获取新版本
     * @param BaseDataRequest $request
     * @return null|string
     */
    public function getVersion(BaseDataRequest $request){
        $name=Constants::getAppKey($request->post('name'));
        $version=Version::where('name',$name)->first();
        if(!$version){
            return self::error(ErrorCode::FAILURE,'不存在该App');
        }
        return self::success(new UpdatePlanResource(UpdatePlan::where('name',$version->id)
            ->where('id',$request->post('id'))
            ->where('status',Constants::OPEN)
            ->with('versionName')
            ->with('afterVersion')
            ->with('beforeVersion')
            ->first()));
    }

    /** 获取协议
     * @param Request $request
     * @return string|null
     */
    public function getAgreement(BaseDataRequest $request){
        $position=$request->get('position',1);
        $title=$request->get('title');
        $agreement=Agreement::where('position',$position)->where('title',$title)->where('status',Constants::OPEN)->orderBy('created_at','DESC')->first();
        return self::success($agreement);
    }

}

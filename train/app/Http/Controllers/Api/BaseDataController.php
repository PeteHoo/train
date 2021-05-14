<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\BaseDataRequest;
use App\Http\Resources\ExhibitionResource;
use App\Http\Resources\SpecialResource;
use App\Http\Resources\UpdatePlanResource;
use App\Models\Agreement;
use App\Models\AppName;
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
    public function mechanism(Request $request)
    {
        $search_words = $request->get('search_words');
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
        $industry = $request->get('industry_id');
        $industry = json_decode($industry);
        if (!$industry) {
            return self::error(ErrorCode::PARAMETER_ERROR, '行业id必填');
        }
        return self::success(Occupation::getOccupationDataByIndustry_id($industry));
    }

    public function allIndustryOccupation()
    {
        $data = Industry::getIndustryObject();
        return self::success($data);
    }

    /** banner接口
     * @return null|string
     */
    public function banner()
    {
        return self::success(ExhibitionResource::collection(
            Exhibition::where('status', Constants::OPEN)
                ->orderBy('sort', 'DESC')
                ->get()));
    }

    /**
     * @param Request $request
     * @return null|string
     */
    public function special(BaseDataRequest $request)
    {
        $occupation_id = $request->get('occupation_id');
        $query = Special::whereIn('occupation_id', json_decode(Auth::user()->occupation_id)??[]);
        if ($occupation_id) {
            $query->where('occupation_id', $occupation_id);
        }
        $data = $query->where('status', Constants::OPEN)
            ->orderBy('sort', 'DESC')
            ->get();
        if (!$data) {
            return self::error(ErrorCode::FAILURE, '未查询到专题');
        }
        return self::success(SpecialResource::collection($data));
    }

    /** 热词列表
     * @return null|string
     */
    public function searchWordsList()
    {
        return self::success(HotSearch::where('status', Constants::OPEN)
            ->where('is_default', Constants::CLOSE)
            ->orderBy('sort', 'DESC')
            ->orderBy('count', 'DESC')
            ->get());
    }

    /** 默认搜索热词
     * @return null|string
     */
    public function searchWordsDefault()
    {
        return self::success(HotSearch::where('status', Constants::OPEN)
            ->where('is_default', Constants::OPEN)
            ->orderBy('sort', 'DESC')
            ->orderBy('count', 'DESC')
            ->first());
    }

    /** 检查版本
     * @param Request $request
     * @return string|null
     */
    public function checkVersion(BaseDataRequest $request)
    {
        $version_code = $request->get('version_code');
        $os = $request->get('os');
        $id = AppName::getAppKey($request->get('name'));
        $version = Version::where('version_code', $version_code)
            ->where('os', $os)
            ->where('name', $id)
            ->first();
        if (!$version) {
            return self::error(ErrorCode::FAILURE, '未查询到版本信息');
        }

        $version = UpdatePlan::where('status', Constants::OPEN)
            ->whereRaw('FIND_IN_SET("' . $version->id . '",before_version)', true)
            ->where('name', $id)
            ->orderBy('after_version', 'DESC')
            ->with('versionName')
            ->with('afterVersionApi')
            ->with('beforeVersionApi')
            ->first();
        if (!$version) {
            return self::error(ErrorCode::FAILURE, '未查询到更新信息');
        }
        return self::success(new UpdatePlanResource($version));
    }


    /** 获取协议
     * @param Request $request
     * @return string|null
     */
    public function getAgreement(BaseDataRequest $request)
    {
        $position = $request->get('position', 1);
        $title = $request->get('title');
        $agreement = Agreement::where('position', $position)->where('title', $title)->where('status', Constants::OPEN)->orderBy('created_at', 'DESC')->first();
        return self::success($agreement);
    }

    /** 获取所有App协议
     * @return null|string
     */
    public function getAgreementList(){
        $agreementList = Agreement::whereIn('position',[Constants::APP_ABOUT_US,Constants::APP_REGISTER,Constants::APP_DISCLAIMER])->where('status', Constants::OPEN)->orderBy('created_at', 'DESC')->get();
        return self::success($agreementList);
    }

}

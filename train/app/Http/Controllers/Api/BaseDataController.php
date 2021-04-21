<?php


namespace App\Http\Controllers\Api;


use App\Http\Resources\ExhibitionResource;
use App\Models\Exhibition;
use App\Models\Industry;
use App\Models\Occupation;
use App\Utils\Constants;
use App\Utils\ErrorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BaseDataController extends ApiController
{
    /** 行业数据
     * @return string|null
     */
    public function industry()
    {
       return self::success(Industry::getIndustryData(Auth::user()->mechanism_id));
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

    public function banner(){
       return self::success(
           new ExhibitionResource(
           Exhibition::where('occupation_id',Auth::user()->occupation_id)
           ->where('status',Constants::OPEN)
           ->orderBy('sort','DESC')
           ->get()));
    }

}

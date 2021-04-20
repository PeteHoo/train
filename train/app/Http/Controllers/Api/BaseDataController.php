<?php


namespace App\Http\Controllers\Api;


use App\Models\Industry;
use App\Models\Occupation;
use App\Utils\ErrorCode;
use Illuminate\Http\Request;


class BaseDataController extends ApiController
{
    public function industry()
    {
       return self::success(Industry::getIndustryData());
    }

    public function occupation(Request $request)
    {
        $industry=$request->get('industry_id');
        if(!$industry){
            return self::error(ErrorCode::PARAMETER_ERROR,'行业id必填');
        }
        return self::success(Occupation::getOccupationDataByIndustry_id($industry));
    }
}

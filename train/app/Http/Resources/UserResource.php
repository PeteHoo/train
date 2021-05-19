<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 14:19
 */

namespace App\Http\Resources;


use App\Models\Industry;
use App\Models\Occupation;
use App\Utils\Constants;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $industryList=Industry::getIndustryData();
//        $occupationList=Occupation::getOccupationIndustry();
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name??'',
            'nick_name' => $this->nick_name??'',
            'phone' => $this->phone,
            'birthday' => $this->birthday??'',
            'sex' => Constants::getSexType($this->sex),
            'attribute' =>  Constants::getAttributeType($this->attribute),
            'avatar' => getImageUrl($this->avatar),
            'mechanism_id' => $this->mechanism_id,
            'mechanism' => $this->mechanism->name??'',
            'temp_mechanism'=>$this->tempMechanism->name??'',
            'industry' => getMultipleItems($industryList,$this->industry_id),
            'occupation' => Occupation::getOccupationIndustry($this->occupation_id),
            'api_token' => $this->api_token,
            'status' => $this->status,
            'has_password'=>$this->password?1:0,
            'created_at'=>$this->created_at->toDateTimeString(),
            'updated_at'=>$this->updated_at->toDateTimeString(),
        ];
    }
}

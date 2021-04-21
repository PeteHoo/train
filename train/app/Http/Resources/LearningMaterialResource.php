<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/18
 * Time: 14:51
 */

namespace App\Http\Resources;


use App\Models\Industry;
use App\Models\Mechanism;
use App\Models\Occupation;
use Illuminate\Http\Resources\Json\JsonResource;

class LearningMaterialResource extends JsonResource
{
    public function toArray($request)
    {
        $mechanismList=Mechanism::getMechanismData();
        $industryList=Industry::getIndustryData();
        $occupationList=Occupation::getOccupationData();
        return [
            'title' => $this->title,
            'description' => $this->description,
            'mechanism' => getMultipleItems($mechanismList,$this->mechanism_id),
            'industry' => getMultipleItems($industryList,$this->industry_id),
            'occupation' => getMultipleItems($occupationList,$this->occupation_id),
            'picture' =>  getImageUrl($this->picture),
            'status' => $this->status,
            'sort' => $this->sort,
        ];
    }
}
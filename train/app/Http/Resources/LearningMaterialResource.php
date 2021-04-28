<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/18
 * Time: 14:51
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LearningMaterialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'mechanism_id' => $this->mechanism_id,
            'industry_id' => $this->industry_id,
            'occupation_id' => $this->occupation_id,
            'mechanism' => $this->mechanism->name??'',
            'industry' => $this->industry->name??'',
            'occupation' => $this->occupation->name??'',
            'picture' =>  getImageUrl($this->picture),
            'status' => $this->status,
            'sort' => $this->sort,
            'view_count'=>$this->view_count,
        ];
    }
}

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
            'title' => $this->title,
            'description' => $this->description,
            'mechanism' => $this->mechanism->name??'',
            'industry' => $this->industry->name??'',
            'occupation' => $this->occupation->name??'',
            'video' =>  getImageUrl($this->video),
            'status' => $this->status,
            'sort' => $this->sort,
        ];
    }
}
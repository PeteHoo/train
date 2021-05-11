<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/30
 * Time: 14:20
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class LearningMaterialRecordResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->learningMaterialDetail->title??'',
            'learning_material' => $this->learningMaterialDetail->learningMaterial->title??'',
            'learning_material_id' => $this->learningMaterialDetail->learningMaterial->id??'',
            'learning_material_picture'=>getImageUrl($this->learningMaterialDetail->learningMaterial->picture??''),
            'chapter_id' => $this->learningMaterialDetail->chapter_id??'',
            'chapter' => $this->learningMaterialDetail->learningMaterialChapter->title??'',
            'description' => $this->learningMaterialDetail->description??'',
            'video' =>  getImageUrl($this->learningMaterialDetail->video??''),
            'sort' => $this->learningMaterialDetail->sort??'',
            'duration' => $this->learningMaterialDetail->duration??'',
            'status' => $this->learningMaterialDetail->status??'',
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'view_count' => $this->learningMaterialDetail->view_count??'',
        ];
    }
}
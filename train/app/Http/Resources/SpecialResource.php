<?php
/**
 * Created by PhpStorm.
 * User: 35304
 * Date: 2021/4/25
 * Time: 19:34
 */

namespace App\Http\Resources;


use App\Models\LearningMaterial;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialResource extends JsonResource
{
    public function toArray($request)
    {
        $materialList=LearningMaterial::getLearningMaterialData();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'occupation_id' => $this->occupation->name??'',
            'material' =>getMultipleItems($materialList,$this->material_ids),
            'status' =>  $this->status,
            'sort' => $this->sort,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'date' => dateDay(),
        ];
    }
}
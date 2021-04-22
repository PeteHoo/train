<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'material_id' => $this->material->name??'',
            'industry_id' => $this->industry_id->name??'',
            'occupation_id' => $this->occupation->name??'',
            'score' => $this->score,
            'question_count' => $this->question_count,
            'status' =>  $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

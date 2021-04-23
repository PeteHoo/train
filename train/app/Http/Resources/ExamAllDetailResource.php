<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ExamAllDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mechanism_id' => $this->mechanism_id,
            'industry_id' => $this->industry_id,
            'occupation_id' => $this->occupation_id,
            'mechanism' => $this->mechanism->name??'',
            'industry' => $this->industry->name??'',
            'occupation' => $this->occupation->name??'',
            'score' => $this->score,
            'question_count' => $this->question_count,
            'status' =>  $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'examDetail'=>$this->examDetail
        ];
    }
}

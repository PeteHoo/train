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
            'choice_question_num' => $this->occupation->choice_question_num??0,
            'choice_question_score' => $this->occupation->choice_question_score??0,
            'judgment_question_num' => $this->occupation->judgment_question_num??0,
            'judgment_question_score' => $this->occupation->judgment_question_score??0,
            'exam_time' => $this->occupation->exam_time??0,
            'passing_grade' => $this->occupation->passing_grade??0,
            'score' => $this->score,
            'question_count' => $this->question_count,
            'status' =>  $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'examDetail'=>$this->examDetail
        ];
    }
}

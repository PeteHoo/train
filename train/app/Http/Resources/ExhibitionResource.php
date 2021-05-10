<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ExhibitionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'picture' => $this->picture,
            'href_way' => (int)$this->href_way,
            'material_id' => (int)$this->material_id,
            'link' => $this->link,
            'status' =>  $this->status,
            'sort' => $this->sort,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

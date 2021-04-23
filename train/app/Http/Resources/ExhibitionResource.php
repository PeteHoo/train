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
            'occupation_id' => $this->occupation->name??'',
            'href_way' => $this->href_way,
            'material_id' => $this->material->name??'',
            'link' => $this->link,
            'status' =>  $this->status,
            'sort' => $this->sort,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class ExamCollectionPaginate extends ResourceCollection
{
    public function toArray($request)
    {
        $paginate = $this->resource->toArray();
        $paginate['data'] = ExamResource::collection($this->collection);
        return $paginate;
    }
}

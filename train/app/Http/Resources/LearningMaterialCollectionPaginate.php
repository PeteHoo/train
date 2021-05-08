<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class LearningMaterialCollectionPaginate extends ResourceCollection
{
    public function toArray($request)
    {
        $paginate = $this->resource->toArray();
        $paginate['data'] = LearningMaterialResource::collection($this->collection);
        $paginate['per_page']=(int)$paginate['per_page'];
        return $paginate;
    }
}

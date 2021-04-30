<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/30
 * Time: 14:36
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class LearningMaterialRecordCollectionPaginate extends ResourceCollection
{
    public function toArray($request)
    {
        $paginate = $this->resource->toArray();
        $paginate['data'] = LearningMaterialRecordResource::collection($this->collection);
        return $paginate;
    }
}
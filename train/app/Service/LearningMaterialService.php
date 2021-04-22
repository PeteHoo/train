<?php


namespace App\Service;


use App\Http\Resources\LearningMaterialCollectionPaginate;
use App\Http\Resources\LearningMaterialResource;
use App\Models\LearningMaterial;

class LearningMaterialService
{
    public static function getRecommendData($id, $occupation_id)
    {
        $query=LearningMaterial::where('id', '<>', $id)
            ->orderBy('sort', 'DESC')
            ->orderBy('created_at', 'DESC');
        if($occupation_id){
            $query->where('occupation_id',$occupation_id);
        }
        return new LearningMaterialCollectionPaginate($query->paginate(request()->get('perPage')));
    }
}

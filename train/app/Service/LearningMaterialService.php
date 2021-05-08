<?php


namespace App\Service;


use App\Http\Resources\LearningMaterialCollectionPaginate;
use App\Http\Resources\LearningMaterialResource;
use App\Models\LearningMaterial;
use App\Utils\Constants;
use Illuminate\Support\Facades\Auth;

class LearningMaterialService
{
    public static function getRecommendData($id, $occupation_id,$mechanism_id)
    {
        $query=LearningMaterial::where('id', '<>', $id)
            ->orderBy('sort', 'DESC')
            ->orderBy('created_at', 'DESC');
        if($occupation_id){
            $query->where('occupation_id',$occupation_id);
        }
        $query->where(function ($where) use($mechanism_id){
            return $where->where('is_open', Constants::OPEN)
                ->orWhere(function ($where) use($mechanism_id) {
                    $where->where('is_open', Constants::CLOSE)
                        ->where('mechanism_id', $mechanism_id);
                });
        });
        return new LearningMaterialCollectionPaginate($query->paginate(request()->get('per_page')));
    }
}

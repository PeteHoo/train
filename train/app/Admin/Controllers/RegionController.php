<?php


namespace App\Admin\Controllers;


use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionController extends ApiController
{
    public function getRegion(Request $request){
        $parent_id=$request->get('parent_id',0);
        return self::success(Region::getRegion($parent_id));
    }

    /** 后端专用
     * @param Request $request
     * @return mixed
     */
    public function backend(Request $request){
        $parent_id = $request->get('q');
        return Region::where('parent_id',$parent_id)->get(['id', DB::raw('name as text')]);
    }
}

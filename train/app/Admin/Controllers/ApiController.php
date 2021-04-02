<?php


namespace App\Admin\Controllers;


use App\Models\CourseItem;
use App\Models\Occupation;
use App\Models\Version;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends AdminController
{
    public function version(Request $request){
        $appId = $request->get('q');
        return Version::where('name',$appId)->get(['id', DB::raw('version_code as text')]);
    }


    public function occupation(Request $request){
        $industryId = $request->get('q');
        return Occupation::where('industry_id',$industryId)->get(['id', DB::raw('name as text')]);
    }
}

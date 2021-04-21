<?php


namespace App\Admin\Controllers;


use App\Models\CourseItem;
use App\Models\Industry;
use App\Models\LearningMaterialChapter;
use App\Models\Occupation;
use App\Models\Region;
use App\Models\Version;
use App\Utils\Constants;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends AdminController
{
    public function version(Request $request)
    {
        $appId = $request->get('q');
        return Version::where('name', $appId)->get(['id', DB::raw('version_code as text')]);
    }


    public function occupation(Request $request)
    {
        $industryId = $request->get('q');
        return Occupation::where('industry_id', $industryId)->get(['id', DB::raw('name as text')]);
    }

    /** 后端专用
     * @param Request $request
     * @return mixed
     */
    public function industry(Request $request)
    {
        $mechanism_id = $request->get('q');
        return Industry::where('status', Constants::OPEN)
            ->orderBy('sort', 'DESC')->where('mechanism_id', $mechanism_id)->get(['id', DB::raw('name as text')]);

    }

    public function chapter(Request $request)
    {
        $learning_material_id = $request->get('q');
        return LearningMaterialChapter::orderBy('sort', 'DESC')->where('learning_material_id', $learning_material_id)->get(['id', DB::raw('title as text')]);

    }
}

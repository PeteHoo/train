<?php

namespace App\Admin\Controllers;

use Admin;
use App\Admin\Metrics\Home\AllData;
use App\Http\Controllers\Controller;
use App\Models\Industry;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
//        $industryList=Industry::getIndustryDataPaginate(11)->toArray();
//        dd($industryList['data']);
        return $content
            ->header(Admin::user()->name)
            ->description(Admin::user()->status==1?'已审核':'未审核')
            ->body(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(3, new AllData('用户访问'));
                        $row->column(3, new AllData('做题数量'));
                        $row->column(3, new AllData('做题时长'));
                        $row->column(3, new AllData('考试成绩'));
                    });
                });
                $row->column(12,function (Column $column){
                    $this->grid();
                });
            });
    }

    protected function grid()
    {
        return Grid::make(new Home(), function (Grid $grid) {});
    }

}

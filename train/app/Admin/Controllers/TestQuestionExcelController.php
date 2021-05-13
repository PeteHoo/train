<?php


namespace App\Admin\Controllers;


use App\Admin\Forms\TestQuestionExcelForm;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;

class TestQuestionExcelController extends AdminController
{
    public function importExcel(Content $content)
    {
        return $content->body(new TestQuestionExcelForm());
    }
}

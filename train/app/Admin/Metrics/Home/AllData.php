<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/5/22
 * Time: 13:20
 */

namespace App\Admin\Metrics\Home;


use App\Models\AppUser;
use App\Models\ExamDetail;
use Dcat\Admin\Widgets\Metrics\Card;
use Illuminate\Http\Request;

class AllData extends Card
{
    protected $title;
    protected $mechanism_id;
    protected $height=100;
    public function __construct($title = null, $mechanism_id = null)
    {
        parent::__construct($title);
        $this->title=$title;
        $this->mechanism_id=$mechanism_id;
    }

    /**
     * 卡片底部内容.
     *
     * @var string|Renderable|\Closure
     */
    protected $footer;

    /**
     * 初始化卡片.
     */
    protected function init()
    {
        parent::init();
    }

    /**
     * 设置卡片高度.
     */
    protected function setUpCardHeight()
    {
        if (! $height = $this->height) {
            return;
        }

        if (is_numeric($height)) {
            $height .= 'px';
        }

        $this->appendHtmlAttribute('style', "min-height:{$height};");
    }

    /**
     * 处理请求.
     *
     * @param Request $request
     *
     * @return void
     */
    public function handle(Request $request)
    {
        $content='';
        if($request->get('mechanism_id')==1){
            if($request->get('title')=='用户总量'){
                $content=AppUser::count();
            }
            if($request->get('title')=='做题数量'){
                $content=ExamDetail::count();
            }
            if($request->get('title')=='做题时长'){
                $content=ExamDetail::count();
            }
            if($request->get('title')=='考试成绩'){
                $content=AppUser::count();
            }
        }
        $this->content($content);
    }

    /**
     * 设置卡片底部内容.
     *
     * @param string|Renderable|\Closure $footer
     *
     * @return $this
     */
    public function footer($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * 渲染卡片内容.
     *
     * @return string
     */
    public function renderContent()
    {
        $content = parent::renderContent();

        return <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
</div>
<div class="ml-1 mt-1 font-weight-bold text-80">
    {$this->renderFooter()}
</div>
HTML;
    }

    /**
     * 渲染卡片底部内容.
     *
     * @return string
     */
    public function renderFooter()
    {
        return $this->toString($this->footer);
    }

    public function parameters() : array
    {
        return [
            'title'=>$this->title,
            'mechanism_id' =>$this->mechanism_id
    ];
}
}
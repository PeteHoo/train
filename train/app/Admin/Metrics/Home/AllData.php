<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/5/22
 * Time: 13:20
 */

namespace App\Admin\Metrics\Home;


use Dcat\Admin\Widgets\Metrics\Card;
use Illuminate\Http\Request;

class AllData extends Card
{
    protected $title;
    protected $height=100;
    public function __construct($title = null, $icon = null)
    {
        parent::__construct($title, $icon);
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
        $this->content(143);
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
}
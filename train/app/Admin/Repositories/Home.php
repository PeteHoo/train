<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/5/22
 * Time: 13:54
 */

namespace App\Admin\Repositories;


use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\EloquentRepository;

class Home extends EloquentRepository
{

    protected $api = '';
    protected $apiKey = '';

    public function get(Grid\Model $model)
    {
        // 获取当前页数
        $currentPage = $model->getCurrentPage();
        // 获取每页显示行数
        $perPage = $model->getPerPage();

        $mechanism_id = $model->filter()->input('mechanism_id');
        $start = ($currentPage - 1) * $perPage;

        $client = new \GuzzleHttp\Client();

        $response = $client->get("{$this->api}?{$this->apiKey}&mechanism_id=$mechanism_id&start=$start&count=$perPage");
        $data = json_decode((string)$response->getBody(), true);

        return $model->makePaginator(
            $data['total'] ?? 0, // 传入总记录数
            $data['subjects'] ?? [] // 传入数据二维数组
        );
    }
}
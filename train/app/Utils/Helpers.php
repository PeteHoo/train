<?php

use Illuminate\Support\Facades\Storage;

/**
 * 友好打印数组
 */
function dda($model)
{
    if (method_exists($model, 'toArray')) {
        dd($model->toArray());
    } else {
        dd($model);
    }
}

/**
 * 开始打印sql
 */
function begin_sql()
{
    \Illuminate\Support\Facades\DB::enableQueryLog();
}

/**
 * Notes:结束打印sql
 */
function dd_sql()
{
    $res = \Illuminate\Support\Facades\DB::getQueryLog();
    $all_time = array_sum(array_column($res, 'time'));
    dd(['all_time' => $all_time, 'all_sql' => $res]);
}

/**
 * 获取数组
 * @param $items
 * @param null $key
 * @return mixed
 */
function getItems($items, $key = null)
{
    if ($key !== null) {
        if (isset($items[$key])) {
            return $items[$key];
        }
    }
    return '';
}

function getKey($items, $content = null)
{
    if ($content !== null) {
        $items = array_flip($items);
        if (isset($items[$content])) {
            return $items[$content];
        }
    }
    return 0;
}


/** 默认获取当前datetime，可传时间戳 转换datetime
 * @param $time
 * @return false|string
 */
function dateNow($time = '')
{
    return $time ? date('Y-m-d H:i:s', $time) : date('Y-m-d H:i:s', time());
}

function dateMonth($time = '')
{
    return $time ? date('Ym', $time) : date('Ym', time());
}

function dateDay($time = '')
{
    return $time ? date('Y-m-d', $time) : date('Y-m-d', time());
}

/** 单文件返回完整路径
 * @param $attribute
 * @return array|mixed
 */
function getCompleteUrl($attribute)
{
    if (!$attribute) {
        return '';
    }
    return Storage::disk('admin')->url($attribute);
}

/** 多文件返回完整路径
 * @param $attributes
 * @return array|mixed
 */
function getCompleteUrls($attributes)
{
    if (!$attributes) {
        return array();
    }
    $attributes = json_decode($attributes, true);
    foreach ($attributes as &$v) {
        $v = Storage::disk('admin')->url($v);
    }
    return $attributes;
}

/** 创建订单
 * @return string
 */
function getOrderId()
{
    $ip = getRealIp();
    $ipNum = intval( implode("", explode('.', $ip)) );
    $timestamp = explode(' ', microtime());
    $sectionOne = sprintf('%04d', $timestamp[1] % 3600);
    $sectionTwo = sprintf('%04d', intval(($timestamp[0] * 1000000) % 1000));
    $sectionThree = sprintf('%04d', mt_rand(0, 987654321) % 1000);
    $sectionFour = sprintf('%04d', crc32($ipNum * (mt_rand(0, 987654321) % 1000)) % 10000);
    return (datetimeNow(). $sectionTwo . $sectionOne . $sectionThree . $sectionFour);
}

/** 获取ip
 * @return bool|mixed|string
 */
function getRealIp(){
    $ip=false;
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
        for ($i = 0; $i < count($ips); $i++) {
            if (!preg_match ("/^(10│172.16│192.168).$/", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

/** 纯数字形式
 * @param string $time
 * @return false|string
 */
function datetimeNow($time=''){
    return $time?date('Ymdhis',$time):date('Ymdhis',time());

}

/** 组合短信实际内容
 * @param $template
 * @param $params
 * @return string|string[]
 */
function getMessageContent($template,$params){
    foreach ($params as $k=>$v){
        $template=str_replace('${'.$k.'}',$v,$template);
    }
    return $template;
}





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

function getMultipleStringItems($items, $keys = null)
{
    if($keys){
        $result=array();
        foreach ($keys as $k=>$v){
            if($v!==null){
                if (isset($items[$v])) {
                    $item['id']=(int)$v;
                    $item['name']=$items[$v];
                    $result[]=$item;
                }
            }
        }
        return $result;
    }
    return array();
}

function getMultipleItems($items, $keys = null)
{
    $keys=json_decode($keys,true);
    if($keys){
        $result=array();
        foreach ($keys as $k=>$v){
            if($v!==null){
                if (isset($items[$v])) {
                    $item['id']=(int)$v;
                    $item['name']=$items[$v];
                    $result[]=$item;
                }
            }
        }
        return $result;
    }
    return array();
}

function getBackendMultipleItems($items, $keys = null)
{
    $keys=json_decode($keys,true);
    if($keys){
        $result=array();
        foreach ($keys as $k=>$v){
            if($v!==null){
                if (isset($items[$v])) {
                    $result[$v]=$items[$v];
                }
            }
        }
        return $result;
    }
    return array();
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
function getUserId()
{
    $ip = getRealIp();
    $ipNum = intval( implode("", explode('.', $ip)) );
    $timestamp = explode(' ', microtime());
    $sectionOne = sprintf('%04d', $timestamp[1] % 3600);
    $sectionTwo = sprintf('%04d', intval(($timestamp[0] * 1000000) % 1000));
    $sectionThree = sprintf('%04d', mt_rand(0, 987654321) % 1000);
    $sectionFour = sprintf('%04d', crc32($ipNum * (mt_rand(0, 987654321) % 1000)) % 10000);
    return (datetimeNow(). $sectionOne. $sectionTwo . $sectionOne . $sectionThree . $sectionFour);
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


function checkPhone($value){
    $money_reg= '/^[1][0-9][0-9]{9}$/';
    return preg_match($money_reg, $value);
}



function u2c($str){
    return preg_replace_callback("#\\\u([0-9a-f]{4})#i",
        function ($r) {
            return iconv('UCS-2BE', 'UTF-8', pack('H4', $r[1]));},
        $str);
}

function generateToken( $len = 32, $md5 = true ) {
    # Seed random number generator
    # Only needed for PHP versions prior to 4.2
    mt_srand( (double)microtime()*1000000 );
    # Array of characters, adjust as desired
    $chars = array(
        'Q', '@', '8', 'y', '%', '^', '5', 'Z', '(', 'G', '_', 'O', '`',
        'S', '-', 'N', '<', 'D', '{', '}', '[', ']', 'h', ';', 'W', '.',
        '/', '|', ':', '1', 'E', 'L', '4', '&', '6', '7', '#', '9', 'a',
        'A', 'b', 'B', '~', 'C', 'd', '>', 'e', '2', 'f', 'P', 'g', ')',
        '?', 'H', 'i', 'X', 'U', 'J', 'k', 'r', 'l', '3', 't', 'M', 'n',
        '=', 'o', '+', 'p', 'F', 'q', '!', 'K', 'R', 's', 'c', 'm', 'T',
        'v', 'j', 'u', 'V', 'w', ',', 'x', 'I', '$', 'Y', 'z', '*'
    );
    # Array indice friendly number of chars;
    $numChars = count($chars) - 1; $token = '';
    # Create random token at the specified length
    for ( $i=0; $i<$len; $i++ )
        $token .= $chars[ mt_rand(0, $numChars) ];
    # Should token be run through md5?
    if ( $md5 ) {
        # Number of 32 char chunks
        $chunks = ceil( strlen($token) / 32 ); $md5token = '';
        # Run each chunk through md5
        for ( $i=1; $i<=$chunks; $i++ )
            $md5token .= md5( substr($token, $i * 32 - 32, 32) );
        # Trim the token
        $token = substr($md5token, 0, $len);
    } return $token;
}


/**
 * 获取图片地址
 * @param $url
 * @return string
 */
function getImageUrl($url)
{
    return $url?config('app.file_url') . $url:'';
}


function get_duration_params($url) {

    $regx = '/.*[&|\?]'. 'duration' .'=([^&]*)(.*)/';
    preg_match($regx, $url, $match);
    return $match[1]??0;
}

/** 将秒数转换成时分秒
 * @param $seconds
 * @return string
 */
function changeTimeType($seconds)
{
    if ($seconds > 3600) {
        $hours = intval($seconds / 3600);
        return $hours . ":" . gmstrftime('%M:%S', $seconds);
    } else {
        return gmstrftime('%H:%M:%S', $seconds);
    }

}
/*
 * 时间转int
 */
function timeToSecond($his)
{
    $str = explode(':', $his);

    $len = count($str);

    if ($len == 3) {
        $time = $str[0] * 3600 + $str[1] * 60 + $str[2];
    } elseif ($len == 2) {
        $time = $str[0] * 60 + $str[1];
    } elseif ($len == 1) {
        $time = $str[0];
    } else {
        $time = 0;
    }
    return $time;
}


function mb_chunk_split($string, $length, $end){
    $array=mb_str_split($string,$length);
    return implode($end, $array);
}

function genUserNumber()
{
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $username = "";
    for ( $i = 0; $i < 6; $i++ )
    {
        $username .= $chars[mt_rand(0, strlen($chars))];
    }
    return strtoupper(base_convert(time() - 1420070400, 10, 36)).$username;
}

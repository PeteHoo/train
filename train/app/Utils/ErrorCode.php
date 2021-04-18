<?php

namespace App\Utils;

class ErrorCode
{
    //成功
    const SUCCESS = 200;
    //参数错误
    const PARAMETER_ERROR = 220;
    //失败
    const FAILURE = 250;
    //token错误
    const AUTH_ERROR=230;


    /**
     * @param null $code
     * @return mixed
     */
    public static function getMessage($code = null)
    {
        $list = [
            self::SUCCESS => '操作成功',
            self::FAILURE => '操作失败',
            self::PARAMETER_ERROR => '参数错误',
        ];
        return getItems($list, $code);
    }
}

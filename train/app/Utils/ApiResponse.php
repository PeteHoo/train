<?php

namespace App\Utils;

trait ApiResponse
{
    /**
     * @param int $code
     * @param string $message
     * @param null $data
     * @return null|string
     */
    public static function error($code, $message = '', $data = array())
    {
        $result = [
            'code' => $code==''?ErrorCode::FAILURE:$code,
            'message' => $message ?: ErrorCode::getMessage($code),
            'data' => $data
        ];
        return response()->json($result);
    }

    /**
     * @param null $data
     * @param int $code
     * @param string $message
     * @return null|string
     */
    public static function success($data = null, $code = ErrorCode::SUCCESS, $message = '')
    {
        $result = [
            'code' => ErrorCode::SUCCESS,
            'message' => $message ?: ErrorCode::getMessage($code),
            'data' => $data
        ];

        return response()->json($result);
    }

    /**
     * @param int $code
     * @param string $message
     * @param null $data
     * @return null|string
     */
    public static function message($message = '', $code = ErrorCode::FAILURE, $data = null)
    {
        $result = [
            'code' => $code,
            'message' => $message ?: ErrorCode::getMessage($code),
            'data' => null
        ];
        return response()->json($result);
    }


}

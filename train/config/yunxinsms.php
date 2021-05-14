<?php
/**
 * Created by PhpStorm.
 * User: caicheng
 * Date: 2018-11-28
 * Time: 14:28
 */

return [
    'AppKey' => env('YUNXIN_SMS_AK', ''), // AppKey
    'AppSecret' => env('YUNXIN_SMS_AS', ''), // AppSecret

    'templates' => [
        'register' => env('YUNXIN_TEMPLATE_REGISTER', ''),
        'login' => env('YUNXIN_TEMPLATE_LOGIN', ''),
        'findPassword' => env('YUNXIN_TEMPLATE_FINDPASSWORD', ''),
        'changePassword' => env('YUNXIN_TEMPLATE_CHANGEPASSWORD', ''),
        'updatePhone' => env('YUNXIN_TEMPLATE_UPDATEPHONE', ''),
        'notice' => env('YUNXIN_TEMPLATE_NOTICE', ''),
    ]
];

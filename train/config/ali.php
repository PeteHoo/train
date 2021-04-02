<?php

return [
    /**
     * Api 接口配置参数
     */
    // 新加密方式验证key
    'accessKeyId' => env('ACCESS_KEY_ID'),
    'accessSecret'=>env('ACCESS_SECRET'),
    'regionId'=>env('REGION_ID'),

    'template'=>[
        'sz_kt' => [//JobEdu - 开通短信
            'template' => 'SMS_172883677',
            'sign' => 'JobEdu',
            'param' => [
                'name' => '',
                'project' => '',
                'tname' => '',
                'tmobile' => '',
            ],
            'ep' => '${name}同学你好！欢迎你成为${project}学员。班主任${tname}老师，电话：${tmobile}，有问题可向班主任咨询。请及时登录《学生会员中心》，核实信息'
        ],
        'sz_jf' => [//JobEdu - 缴费通知
            'template' => 'SMS_173250880',
            'sign' => 'JobEdu',
            'param' => [
                'user' => '',
                'name' => '',
                'fee' => '',
                'received' => '',
                'pay' => '',
                'owe' => '',
            ],
            'ep' => '${user}同学你好！您本次缴费项目：${name}，应缴：${fee}元，已缴：${received}元，本次缴费：${pay}元，欠缴：${owe}元。请及时登录《学生会员中心》，核实信息。'
        ],
        'mep_yzm' => [//麦能网 - 验证码
            'template' => 'SMS_172883650',
            'sign' => '麦能网',
            'param' => [
                'code' => '',
            ],
            'ep' => '您的验证码是${code}，有效期5分钟。'
        ],
        'sz_yzm' => [//吉博社招 - 验证码
            'template' => 'SMS_172883643',
            'sign' => '吉博社招',
            'param' => [
                'code' => '',
            ],
            'ep' => '您的验证码是${code}，有效期5分钟。'
        ],
    ],
];

<?php


namespace App\Utils;


class Constants
{
    /**
     * 状态
     */
    const CLOSE = 0;
    const OPEN = 1;

    public static function getStatusItems()
    {
        return [
            self::CLOSE => '否',
            self::OPEN => '是',
        ];
    }

    public static function getStatusType($status)
    {
        return getItems(self::getStatusItems(), $status);
    }

    /**
     * 审核状态
     */
    const ANDROID = 1;
    const IOS = 2;


    public static function getOsItems()
    {
        return [
            self::ANDROID => 'android',
            self::IOS => 'ios',
        ];
    }

    public static function getOsType($os)
    {
        return getItems(self::getOsItems(), $os);
    }

    /**
     * 展示位位置
     */
    const BANNER = 1;
    const THEME = 2;


    public static function getExhibitionItems()
    {
        return [
            self::BANNER => 'banner',
            self::THEME => '专题',
        ];
    }

    public static function getExhibitionType($os)
    {
        return getItems(self::getExhibitionItems(), $os);
    }

    /**
     * 跳转方式
     */
    const H5 = 1;
    const IN = 2;


    public static function getHrefWayItems()
    {
        return [
            self::H5 => 'H5',
            self::IN => '站内跳转',
        ];
    }

    public static function getHrefWayType($way)
    {
        return getItems(self::getHrefWayItems(), $way);
    }

    /**
     * 跳转方式
     */
    const FOOD = 1;
    const MAKE_UP = 2;
    const DRUGS = 3;

    public static function getAppItems()
    {
        return [
            self::FOOD => '食品',
            self::MAKE_UP => '化妆',
            self::DRUGS => '药品',
        ];
    }

    public static function getAppType($app)
    {
        return getItems(self::getAppItems(), $app);
    }

    public static function getAppKey($name)
    {
        return getItems(array_flip(self::getAppItems()), $name);
    }
    /**
     * 协议位置
     */
    const BACKEND_SETTLE = 1;
    const APP_ABOUT_US = 2;
    const APP_REGISTER = 3;
    const APP_DISCLAIMER=4;

    public static function getAgreementItems()
    {
        return [
            self::BACKEND_SETTLE => '后端-机构入驻',
            self::APP_ABOUT_US => 'APP端-关于我们',
            self::APP_REGISTER=>'APP端-用户注册',
            self::APP_DISCLAIMER=>'APP端-免责声明',
        ];
    }

    public static function getAgreementType($app)
    {
        return getItems(self::getAgreementItems(), $app);
    }


    const MECHANISM = 1;
    const ENTERPRISE = 2;

    public static function getMemberItems()
    {
        return [
            self::MECHANISM => '机构',
            self::ENTERPRISE => '企业',
        ];
    }

    public static function getMemberType($type){
        return getItems(self::getMemberItems(), $type);
    }

    const SINGLE_CHOICE = 1;
    const JUDGMENT = 2;

    public static function getQuestionTypeItems()
    {
        return [
            self::SINGLE_CHOICE => '单选题',
            self::JUDGMENT => '判断题',
        ];
    }

    public static function getQuestionType($type){
        return getItems(self::getQuestionTypeItems(), $type);
    }

    const TEXT = 1;
    const IMAGE = 2;

    public static function getQuestionAttributeItems()
    {
        return [
            self::TEXT => '文本',
            self::IMAGE => '图片',
        ];
    }

    public static function getQuestionAttributeType($type){
        return getItems(self::getQuestionAttributeItems(), $type);
    }


    public static function getSingleChoiceOptionItems()
    {
        return [
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
        ];
    }

    public static function getJudgmentOptionItems()
    {
        return [
            '正确' => '正确',
            '错误' => '错误',
        ];
    }

    /**
     * 性别状态
     */
    const MALE = 1;
    const FEMALE = 2;

    public static function getSexItems()
    {
        return [
            self::MALE => '男',
            self::FEMALE => '女',
        ];
    }

    public static function getSexType($sex)
    {
        return getItems(self::getSexItems(), $sex);
    }

    /**
     * 用户属性
     */
    const PERSONAL_ATTRIBUTE = 1;
    const ENTERPRISE_ATTRIBUTE = 2;
    const MECHANISM_ATTRIBUTE = 3;

    public static function getAttributeItems()
    {
        return [
            self::PERSONAL_ATTRIBUTE => '个人',
            self::ENTERPRISE_ATTRIBUTE => '企业',
            self::MECHANISM_ATTRIBUTE => '机构',
        ];
    }

    public static function getAttributeType($attribute)
    {
        return getItems(self::getAttributeItems(), $attribute);
    }

    /**
     * 短信类型
     */
    const LOGIN=1;
    const CHANGE_PASSWORD=2;
    public static function getPhoneCodeItems()
    {
        return [
            self::LOGIN => '登录',
            self::CHANGE_PASSWORD => '修改密码',
        ];
    }
}

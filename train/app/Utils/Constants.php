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

    /**
     * 协议位置
     */
    const BACKEND_SETTLE = 1;
    const APP_ABOUT_US = 2;
    const APP_REGISTER = 3;

    public static function getAgreementItems()
    {
        return [
            self::BACKEND_SETTLE => '后端-机构入驻',
            self::APP_ABOUT_US => 'APP端-关于我们',
            self::APP_REGISTER=>'APP端-用户注册',
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


}

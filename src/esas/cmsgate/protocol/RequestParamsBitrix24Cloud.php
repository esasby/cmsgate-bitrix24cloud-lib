<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 14.04.2020
 * Time: 14:59
 */

namespace esas\cmsgate\protocol;


class RequestParamsBitrix24Cloud
{
    const LANG = 'lang';
    const ORDER_ID = 'orderId';
    const PAYMENT_ID = 'paymentId';
    const AMOUNT = 'amount';
    const PAYMENT_SYSTEM_ID = 'BX_PAYSYSTEM_ID';
    const SHOP_ID = 'shopId';
    const DOMAIN = "domain";
    const PROTOCOL = "PROTOCOL";
    const AUTH_ID = "AUTH_ID"; //old style
    const ACCESS_TOKEN = "access_token";
    const EXPIRES = "expires";
    const AUTH_EXPIRES = "AUTH_EXPIRES"; //old style
    const REFRESH_ID = "REFRESH_ID"; //old style
    const REFRESH_TOKEN = "refresh_token";
    const MEMBER_ID = "member_id";
    const RETURN_TO_SHOP_URL = "BX_RETURN_URL";
//    const SANDBOX = "sandbox";

    public static function getDomain() {
        return $_REQUEST['auth'][RequestParamsBitrix24Cloud::DOMAIN];
    }

    public static function getMemberId() {
        return $_REQUEST['auth'][RequestParamsBitrix24Cloud::MEMBER_ID];
    }

    public static function getPaymentId() {
        return $_REQUEST[RequestParamsBitrix24Cloud::PAYMENT_ID];
    }

    public static function getOrderId() {
        return $_REQUEST[RequestParamsBitrix24Cloud::ORDER_ID];
    }

    public static function getShopId() {
        return $_REQUEST[RequestParamsBitrix24Cloud::SHOP_ID];
    }

    public static function getPaymentAmount() {
        return $_REQUEST[RequestParamsBitrix24Cloud::AMOUNT];
    }

    public static function getAccessToken() {
        return $_REQUEST['auth'][RequestParamsBitrix24Cloud::ACCESS_TOKEN];
    }

    public static function getExpires() {
        return $_REQUEST['auth'][RequestParamsBitrix24Cloud::EXPIRES];
    }

    public static function getRefreshToken() {
        return $_REQUEST['auth'][RequestParamsBitrix24Cloud::REFRESH_TOKEN];
    }

    public static function getReturnToShopUrl() {
        return $_REQUEST[RequestParamsBitrix24Cloud::RETURN_TO_SHOP_URL];
    }
}
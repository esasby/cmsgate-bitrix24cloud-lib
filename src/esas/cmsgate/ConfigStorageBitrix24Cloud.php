<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 15.07.2019
 * Time: 13:14
 */

namespace esas\cmsgate;

use esas\cmsgate\protocol\RequestParamsBitrix24Cloud;

/**
 * Все настройки удобнее хранить на стороне bitrix24 и получать их по REST, т.к. в Bitrix могут быть созданы несколько
 * способов оплаты, на одном и том же handler. Поэтому наследуется от ConfigStorageCmsArray, а не от ConfigStorageCloud
 * @package esas\cmsgate
 */
class ConfigStorageBitrix24Cloud extends ConfigStorageCmsArray
{
    public function __construct() {
        //получаем настройки
        $orderData = BridgeConnector::fromRegistry()->getOrderCacheService()->getSessionOrderCacheSafe()->getOrderData();
        $paymentId = $orderData[RequestParamsBitrix24Cloud::PAYMENT_ID];
        $psId = $orderData[RequestParamsBitrix24Cloud::PAYMENT_SYSTEM_ID];
        $restPaysystemConfig = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(true)->salePaysystem()->getSettingsForPayment($paymentId, $psId);
        parent::__construct($restPaysystemConfig);
    }

    public function getConstantConfigValue($key) {
        switch ($key) {
            case ConfigFields::orderStatusPending():
            case ConfigFields::orderPaymentStatusPending():
                return "cmsgate_pending";
            case ConfigFields::orderStatusPayed():
            case ConfigFields::orderPaymentStatusPayed():
                return "cmsgate_payed";
            case ConfigFields::orderStatusFailed():
            case ConfigFields::orderPaymentStatusFailed():
                return "cmsgate_failed";
            case ConfigFields::orderStatusCanceled():
            case ConfigFields::orderPaymentStatusCanceled():
                return "cmsgate_canceled";
            case ConfigFields::useOrderNumber():
                return true;
            default:
                return null;
        }
    }

    public function createCmsRelatedKey($key) {
        return 'ps_' . $key;
    }
}
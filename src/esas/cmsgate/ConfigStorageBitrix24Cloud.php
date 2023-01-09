<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 15.07.2019
 * Time: 13:14
 */

namespace esas\cmsgate;

use esas\cmsgate\bitrix\BitrixRequest;
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
        $orderCache = BridgeConnector::fromRegistry()->getOrderCacheService()->getSessionOrderCache();
        if ($orderCache != null) {
            $orderData = BridgeConnector::fromRegistry()->getOrderCacheService()->getSessionOrderCache()->getOrderData();
            $paymentId = $orderData[RequestParamsBitrix24Cloud::PAYMENT_ID];
            $psId = $orderData[RequestParamsBitrix24Cloud::PAYMENT_SYSTEM_ID];
            $restPaysystemConfig = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(true)->salePaysystem()->getSettingsForPayment($paymentId, $psId);
        } else if (RequestParamsBitrix24Cloud::getPaymentId() != null) {
            $paymentId = RequestParamsBitrix24Cloud::getPaymentId();
            $payment = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(true)->salePayment()->get($paymentId);
            $psId = $payment->getPaysystemId();
            $restPaysystemConfig = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(true)->salePaysystem()->getSettingsForPayment($paymentId, $psId);
        }
        parent::__construct($restPaysystemConfig);
    }

    public function createCmsRelatedKey($key) {
        return 'ps_' . $key;
    }

    public function convertToBoolean($cmsConfigValue)
    {
        return $cmsConfigValue == 'Y' || $cmsConfigValue == '1' || $cmsConfigValue == "true";
    }
}
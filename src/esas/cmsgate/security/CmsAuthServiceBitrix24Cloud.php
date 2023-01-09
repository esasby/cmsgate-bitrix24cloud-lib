<?php


namespace esas\cmsgate\security;


use esas\cmsgate\bitrix\BitrixRequest;
use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\BridgeConnectorBitrix24;
use esas\cmsgate\utils\CMSGateException;

class CmsAuthServiceBitrix24Cloud extends CmsAuthService
{
    public function checkAuth(&$request)
    {
        $shopConfig = BridgeConnectorBitrix24::fromRegistry()->getShopConfigRepository()->findByMemberId(RequestParamsBitrix24Cloud::getShopId());
        if ($shopConfig == null)
            throw new CMSGateException('Auth is incorrect');
        $payment = CmsConnectorBitrix24Cloud::fromRegistry()->createBitrix24CloudProtocol($shopConfig)->salePayment()->get(RequestParamsBitrix24Cloud::getPaymentId());
        if ($payment->getAmount() != RequestParamsBitrix24Cloud::getPaymentAmount())
            throw new CMSGateException('Auth is incorrect');
        return $shopConfig;
    }
}
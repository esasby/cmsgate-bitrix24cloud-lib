<?php


namespace esas\cmsgate\security;


use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\BridgeConnectorBitrix24;
use esas\cmsgate\protocol\RequestParamsBitrix24Cloud;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\URLUtils;

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



        if (array_key_exists(RequestParamsBitrix24Cloud::RETURN_TO_SHOP_URL, $request)) // bitrix bug fix. при позварте в запросе накапливаются дубликаты параметров user_lang
            $request[RequestParamsBitrix24Cloud::RETURN_TO_SHOP_URL] = URLUtils::removeParamDuplicates($request[RequestParamsBitrix24Cloud::RETURN_TO_SHOP_URL]);
        return $shopConfig;
    }
}
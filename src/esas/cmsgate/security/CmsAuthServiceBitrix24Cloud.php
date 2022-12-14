<?php


namespace esas\cmsgate\security;


use esas\cmsgate\protocol\RequestParamsBitrix24Cloud;
use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\BridgeConnectorBitrix24;
use esas\cmsgate\utils\CMSGateException;

class CmsAuthServiceBitrix24Cloud extends CmsAuthService
{
    public function checkAuth(&$request)
    {
        /**
         * Отравляем на portal запрос проверки авторизации, по тем данным, что пришли в запросе.
         * Если ок, то получаем из локальной БД config данные (админские, сохраненные на этапе install)
         * и уже их используем для авторизоваться на bitrix24 при работе с REST и запрошиваем настройки
         **/
        $order = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(false)->salePayment()->get(RequestParamsBitrix24Cloud::PAYMENT_ID);
        if ($order == null) {
            throw new CMSGateException('Auth is incorrect');
        }
        return BridgeConnectorBitrix24::fromRegistry()->getShopConfigRepository()->findByMemberId(RequestParamsBitrix24Cloud::MEMBER_ID);
    }
}
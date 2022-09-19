<?php


namespace esas\cmsgate\security;


use esas\cmsgate\bitrix24cloud\RequestParamsBitrix24Cloud;
use esas\cmsgate\CloudRegistry;
use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\utils\CMSGateException;

class ApiAuthServiceBitrix24Cloud extends ApiAuthService
{
    public function checkAuth(&$request)
    {
        /**
         * Отравляем на portal запрос проверки авторизации, по тем данным, что пришли в запросе.
         * Если ок, то получаем из локальной БД config данные (админские, сохраненные на этапе install)
         * и уже их используем для авторизоваться на bitrix24 при работе с REST и запрошиваем настройки
         **/
        $order = CmsConnectorBitrix24Cloud::getInstance()->getBitrix24Api(false)->salePayment()->get(RequestParamsBitrix24Cloud::ORDER_ID);
        if ($order == null) {
            throw new CMSGateException('Auth is incorrect');
        }
        $configCache = CloudRegistry::getRegistry()->getConfigCacheRepository()->getByLogin(RequestParamsBitrix24Cloud::MEMBER_ID);
        return $configCache;
    }
}
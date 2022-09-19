<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 13.04.2020
 * Time: 12:23
 */

namespace esas\cmsgate;

use esas\cmsgate\bitrix24cloud\Bitrix24CloudProtocol;
use esas\cmsgate\bitrix24cloud\Bitrix24RestClient;
use esas\cmsgate\descriptors\CmsConnectorDescriptor;
use esas\cmsgate\descriptors\VendorDescriptor;
use esas\cmsgate\descriptors\VersionDescriptor;
use esas\cmsgate\lang\LocaleLoaderBitrix24Cloud;
use esas\cmsgate\wrappers\OrderWrapperBitrix24Cloud;

class CmsConnectorBitrix24Cloud extends CmsConnectorCached
{
    /**
     * @var Bitrix24CloudProtocol
     */
    protected $bitrix24Api;

    /**
     * Для удобства работы в IDE и подсветки синтаксиса.
     * @return $this
     */
    public static function getInstance()
    {
        return Registry::getRegistry()->getCmsConnector();
    }

    public function createOrderWrapperCached($cache)
    {
        return new OrderWrapperBitrix24Cloud($cache);
    }

    public function createCmsConnectorDescriptor()
    {
        return new CmsConnectorDescriptor(
            "cmsgate-bitrix24cloud-lib",
            new VersionDescriptor(
                "v1.17.0",
                "2022-08-25"
            ),
            "Cmsgate Bitrix24 cloud connector",
            "https://bitbucket.esas.by/projects/CG/repos/cmsgate-bitrix24cloud-lib/browse",
            VendorDescriptor::esas(),
            "bitrix24cloud"
        );
    }

    public function createLocaleLoaderCached($cache)
    {
        return new LocaleLoaderBitrix24Cloud();
    }

    public function createConfigStorage()
    {
        return new ConfigStorageBitrix24Cloud();
    }

    public function getNotificationURL() {
        $cache = CloudRegistry::getRegistry()->getOrderCacheService()->getSessionOrderCacheSafe();
        return $cache->getOrderData()[RequestParamsTilda::NOTIFICATION_URL];
    }

    public function getReturnToShopSuccessURL()
    {
        $cache = CloudRegistry::getRegistry()->getOrderCacheService()->getSessionOrderCacheSafe();
        return $cache->getOrderData()[RequestParamsTilda::SUCCESS_URL];
    }

    public function getReturnToShopFailedURL()
    {
        $cache = CloudRegistry::getRegistry()->getOrderCacheService()->getSessionOrderCacheSafe();
        return $cache->getOrderData()[RequestParamsTilda::FAILED_URL];
    }

    public function getBitrix24Api($adminAccess = true) {
        if ($this->bitrix24Api == null)
            $this->bitrix24Api = $this->createBitrix24Api($adminAccess);
        return $this->bitrix24Api;
    }

    protected function createBitrix24Api($adminAccess)
    {
        return new Bitrix24CloudProtocol(new Bitrix24RestClient()); //todo init correctly
    }
}
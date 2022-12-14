<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 13.04.2020
 * Time: 12:23
 */

namespace esas\cmsgate;

use esas\cmsgate\protocol\RequestParamsBitrix24Cloud;
use esas\cmsgate\bridge\ShopConfigBitrix24;
use esas\cmsgate\descriptors\CmsConnectorDescriptor;
use esas\cmsgate\descriptors\VendorDescriptor;
use esas\cmsgate\descriptors\VersionDescriptor;
use esas\cmsgate\lang\LocaleLoaderBitrix24Cloud;
use esas\cmsgate\protocol\Bitrix24CloudProtocol;
use esas\cmsgate\protocol\Bitrix24RestClient;
use esas\cmsgate\wrappers\OrderWrapperBitrix24Cloud;

class CmsConnectorBitrix24Cloud extends CmsConnectorBridge
{
    /**
     * @var Bitrix24CloudProtocol
     */
    protected $bitrix24Api;

    /**
     * @var Bitrix24CloudProtocol
     */
    protected $bitrix24ApiAdminAccess;

    /**
     * Для удобства работы в IDE и подсветки синтаксиса.
     * @return $this
     */
    public static function fromRegistry() {
        return Registry::getRegistry()->getCmsConnector();
    }

    public function createOrderWrapperCached($cache) {
        return new OrderWrapperBitrix24Cloud($cache);
    }

    public function createCmsConnectorDescriptor() {
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

    public function createLocaleLoaderCached($cache) {
        return new LocaleLoaderBitrix24Cloud();
    }

    public function createConfigStorage() {
        return new ConfigStorageBitrix24Cloud();
    }

    public function getReturnToShopSuccessURL() {
        return Registry::getRegistry()->getConfigWrapper()->getConfig(ConfigFieldsBitrix24Cloud::returnUrlSuccess());
    }

    public function getReturnToShopFailedURL() {
        return Registry::getRegistry()->getConfigWrapper()->getConfig(ConfigFieldsBitrix24Cloud::returnUrlFailed());
    }

    public function getBitrix24Api($adminAccess = true) {
        if ($adminAccess) {
            if ($this->bitrix24ApiAdminAccess == null)
                $this->bitrix24ApiAdminAccess = $this->createBitrix24Api(true);
            return $this->bitrix24ApiAdminAccess;
        } else {
            if ($this->bitrix24Api == null)
                $this->bitrix24Api = $this->createBitrix24Api(false);
            return $this->bitrix24Api;
        }
    }

    protected function createBitrix24Api($adminAccess) {
        $client = new Bitrix24RestClient();
        if ($adminAccess) {
            /** @var ShopConfigBitrix24 $shopConfig */
            $shopConfig = BridgeConnector::fromRegistry()->getShopConfigService()->getSessionShopConfigSafe();
            $client->setDomain($shopConfig->getDomain());
            $client->setMemberId($shopConfig->getMemberId());
            $client->setAccessToken($shopConfig->getAccessToken());
            $client->setRefreshToken($shopConfig->getRefreshToken());
        } else {
            $client->setDomain($_REQUEST[RequestParamsBitrix24Cloud::DOMAIN]);
            $client->setMemberId($_REQUEST[RequestParamsBitrix24Cloud::MEMBER_ID]);
            $client->setAccessToken($_REQUEST[RequestParamsBitrix24Cloud::AUTH_ID]);
            $client->setRefreshToken($_REQUEST[RequestParamsBitrix24Cloud::REFRESH_ID]);
        }
        $client->setApplicationId('ID from MP');
        $client->setApplicationCode('Code from MP');
        return new Bitrix24CloudProtocol($client);
    }
}
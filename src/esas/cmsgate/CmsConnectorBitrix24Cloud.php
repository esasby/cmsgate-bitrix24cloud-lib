<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 13.04.2020
 * Time: 12:23
 */

namespace esas\cmsgate;

use esas\cmsgate\bitrix\BitrixRequest;
use esas\cmsgate\bridge\ShopConfigBitrix24;
use esas\cmsgate\descriptors\CmsConnectorDescriptor;
use esas\cmsgate\descriptors\VendorDescriptor;
use esas\cmsgate\descriptors\VersionDescriptor;
use esas\cmsgate\lang\LocaleLoaderBitrix24Cloud;
use esas\cmsgate\protocol\Bitrix24CloudProtocol;
use esas\cmsgate\protocol\Bitrix24RestClient;
use esas\cmsgate\protocol\RequestParamsBitrix24Cloud;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\wrappers\OrderWrapperBitrix24Cloud;

class CmsConnectorBitrix24Cloud extends CmsConnectorBridge
{
    /**
     * @var BridgeConfigBitrix24Cloud
     */
    private $config;

    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
    }
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
                "v1.18.4",
                "2023-01-18"
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
        $orderCache = BridgeConnectorBitrix24::fromRegistry()->getOrderCacheService()->getSessionOrderCacheSafe();
        return $orderCache->getOrderData()[RequestParamsBitrix24Cloud::RETURN_TO_SHOP_URL];
    }

    public function getReturnToShopFailedURL() {
        return $this->getReturnToShopSuccessURL();
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
        if ($adminAccess) {
            /** @var ShopConfigBitrix24 $shopConfig */
            $shopConfig = BridgeConnector::fromRegistry()->getShopConfigService()->getSessionShopConfigSafe();
            return $this->createBitrix24CloudProtocol($shopConfig);
        } else {
            $client = new Bitrix24RestClient();
            $client->setDomain(RequestParamsBitrix24Cloud::getDomain());
            $client->setMemberId(RequestParamsBitrix24Cloud::getMemberId());
            $client->setAccessToken(RequestParamsBitrix24Cloud::getAccessToken());
            $client->setRefreshToken(RequestParamsBitrix24Cloud::getRefreshToken());
            $client->setApplicationId($this->config->getAppId());
            $client->setApplicationSecret($this->config->getAppSecret());
            $client->setDebugMode($this->config->isDebugMode());
            return new Bitrix24CloudProtocol($client);
        }
    }

    public function createBitrix24CloudProtocol(ShopConfigBitrix24 $shopConfig) {
        $client = new Bitrix24RestClient();
        $client->setDomain($shopConfig->getDomain());
        $client->setMemberId($shopConfig->getMemberId());
        $client->setAccessToken($shopConfig->getAccessToken());
        $client->setRefreshToken($shopConfig->getRefreshToken());
        $client->setApplicationId($this->config->getAppId());
        $client->setApplicationSecret($this->config->getAppSecret());
        $client->setDebugMode($this->config->isDebugMode());
        $this->refreshTokens($client, $shopConfig);
        return new Bitrix24CloudProtocol($client);
    }

    /**
     * @param $client Bitrix24RestClient
     * @param $shopConfig ShopConfigBitrix24
     * @throws CMSGateException
     */
    private function refreshTokens(&$client,&$shopConfig ) {
        $resExpire = $client->isAccessTokenExpire();
        if ($resExpire) {
            $this->logger->info('Access token is expired for domain[' . $client->getDomain() . "]");
            $result = $client->getNewAccessToken();
            if ($result === false) {
                throw new CMSGateException('Access token refresh error for domain[' . $client->getDomain() . "]");
            } elseif (is_array($result) && array_key_exists('access_token', $result) && !empty($result['access_token'])) {
                $shopConfig->setRefreshToken($result['refresh_token']);
                $shopConfig->setAccessToken($result['access_token']);
                BridgeConnectorBitrix24::fromRegistry()->getShopConfigService()->saveConfig($shopConfig);
                $client->setAccessToken($shopConfig->getAccessToken());
                $client->setRefreshToken($shopConfig->getRefreshToken());
            } else {
                throw new CMSGateException('Access token refresh error for domain[' . $client->getDomain() . "]");
            }
        }
    }

    public function getModuleActionName()
    {
        return str_replace('.', '_', Registry::getRegistry()->getModuleDescriptor()->getModuleMachineName());
    }
}
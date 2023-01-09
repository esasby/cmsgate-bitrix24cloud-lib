<?php


namespace esas\cmsgate;


use esas\cmsgate\bitrix\BitrixRequest;
use esas\cmsgate\bridge\OrderCacheRepository;
use esas\cmsgate\bridge\OrderCacheRepositoryPDO;
use esas\cmsgate\bridge\ShopConfigBitrix24Repository;
use esas\cmsgate\bridge\ShopConfigBitrix24RepositoryPDO;
use esas\cmsgate\security\CmsAuthServiceBitrix24Cloud;
use esas\cmsgate\utils\CMSGateException;

abstract class BridgeConnectorBitrix24 extends BridgeConnectorPDO
{
    /**
     * Для удобства работы в IDE и подсветки синтаксиса.
     * @return $this
     */
    public static function fromRegistry() {
        return parent::fromRegistry();
    }

    public function createAdminConfigPage() {
        throw new CMSGateException("Not implemented. No admin config page for bitrix24cloud");
    }

    public function createAdminLoginPage() {
        throw new CMSGateException("Not implemented. No admin login page for bitrix24cloud");
    }

    /**
     * @var ShopConfigBitrix24Repository
     */
    protected $shopConfigRepository;

    /**
     * @return ShopConfigBitrix24Repository
     */
    public function getShopConfigRepository() {
        if ($this->shopConfigRepository == null)
            $this->shopConfigRepository = $this->createShopConfigRepository();
        return $this->shopConfigRepository;
    }

    /**
     * @return ShopConfigBitrix24Repository
     * @throws CMSGateException
     */
    protected function createShopConfigRepository() {
        return new ShopConfigBitrix24RepositoryPDO($this->getPDO());
    }

    protected function createCmsAuthService() {
        return new CmsAuthServiceBitrix24Cloud();
    }

    public abstract function getHandlerActionUrl();

    /**
     * В Bitrix для хранения реальных и тестовых заказаов используются различные таблицы
     * @var OrderCacheRepository
     */
//    protected $orderCacheRepositoryForSandbox;

//    /**
//     * @return OrderCacheRepository
//     */
//    public function getOrderCacheRepository() {
//        if (!RequestParamsBitrix24Cloud::isSandbox()) {
//            return parent::getOrderCacheRepository();
//        } else {
//            if ($this->orderCacheRepositoryForSandbox == null) {
//                $tableName = Registry::getRegistry()->getModuleDescriptor()->getCmsAndPaysystemName()
//                    . '_order_cache_sandbox';
//                $this->orderCacheRepositoryForSandbox = new OrderCacheRepositoryPDO($this->getPDO(), $tableName);
//            }
//            return $this->orderCacheRepositoryForSandbox;
//        }
//    }
}
<?php


namespace esas\cmsgate\protocol;

use esas\cmsgate\protocol\bitrix24cloud\CrmContactApi;
use esas\cmsgate\protocol\bitrix24cloud\SaleBasketItemApi;
use esas\cmsgate\protocol\bitrix24cloud\SaleOrderApi;
use esas\cmsgate\protocol\bitrix24cloud\SalePaymentApi;
use esas\cmsgate\protocol\bitrix24cloud\SalePaysystemApi;
use esas\cmsgate\protocol\bitrix24cloud\SalePersonTypeApi;
use esas\cmsgate\protocol\bitrix24cloud\SaleStatusApi;
use esas\cmsgate\protocol\bitrix24cloud\UserApi;
use esas\cmsgate\utils\Logger;

class Bitrix24CloudProtocol
{
    protected $logger;
    /**
     * @var Bitrix24RestClient
     */
    protected $restClient = null;

    /**
     * @param $client Bitrix24RestClient
     */
    public function __construct(Bitrix24RestClient $client) {
        $this->logger = Logger::getLogger(get_class($this));
        $this->restClient = $client;
    }

    /**
     * @return SalePaysystemApi
     */
    public function salePaysystem() {
        return new SalePaysystemApi($this->restClient);
    }

    /**
     * @return SaleOrderApi
     */
    public function saleOrder() {
        return new SaleOrderApi($this->restClient);
    }

    /**
     * @return SalePaymentApi
     */
    public function salePayment() {
        return new SalePaymentApi($this->restClient);
    }

    /**
     * @return SaleBasketItemApi
     */
    public function saleBasket() {
        return new SaleBasketItemApi($this->restClient);
    }

    /**
     * @return SaleStatusApi
     */
    public function saleStatus() {
        return new SaleStatusApi($this->restClient);
    }

    /**
     * @return SalePersonTypeApi
     */
    public function salePersonTypes() {
        return new SalePersonTypeApi($this->restClient);
    }

    /**
     * @return CrmContactApi
     */
    public function crmContact() {
        return new CrmContactApi($this->restClient);
    }

    /**
     * @return UserApi
     */
    public function user() {
        return new UserApi($this->restClient);
    }
}
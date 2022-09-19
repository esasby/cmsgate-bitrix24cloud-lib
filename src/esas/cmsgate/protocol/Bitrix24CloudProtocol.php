<?php


namespace esas\cmsgate\bitrix24cloud;


use esas\cmsgate\bitrix24cloud\entity\Bitrix24SaleBasketItem;
use esas\cmsgate\bitrix24cloud\entity\Bitrix24SaleOrder;
use esas\cmsgate\bitrix24cloud\entity\Bitrix24SalePayment;
use esas\cmsgate\bitrix24cloud\entity\Bitrix24SalePaysystem;
use esas\cmsgate\bitrix24cloud\entity\Bitrix24User;

class Bitrix24CloudProtocol
{
    /**
     * @var Bitrix24RestClient
     */
    protected $restClient = null;

    /**
     * @param $client Bitrix24RestClient
     */
    public function __construct(Bitrix24RestClient $client)
    {
        $this->restClient = $client;
    }

    /**
     * @return Bitrix24SalePaysystem
     */
    public function salePaysystem() {
        return new Bitrix24SalePaysystem($this->restClient);
    }

    /**
     * @return Bitrix24SaleOrder
     */
    public function saleOrder() {
        return new Bitrix24SaleOrder($this->restClient);
    }

    /**
     * @return Bitrix24SalePayment
     */
    public function salePayment() {
        return new Bitrix24SalePayment($this->restClient);
    }

    /**
     * @return Bitrix24SaleBasketItem
     */
    public function saleBasket() {
        return new Bitrix24SaleBasketItem($this->restClient);
    }

    /**
     * @return Bitrix24User
     */
    public function user() {
        return new Bitrix24User($this->restClient);
    }
}
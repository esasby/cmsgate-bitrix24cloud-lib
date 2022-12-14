<?php

namespace esas\cmsgate\wrappers;

use esas\cmsgate\bitrix24cloud\entity\Bitrix24SaleOrder;
use esas\cmsgate\bitrix24cloud\entity\Bitrix24SaleShipment;
use esas\cmsgate\bitrix24cloud\entity\Bitrix24User;
use esas\cmsgate\bridge\OrderCache;
use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\OrderStatus;

/**
 * Не может в чистом виде наследоваться от OrderWrapperCached и работать только с сохраненным в БД шлюза
 * данными по заказу (как в Tilda), т.к. в Bitrix24Cloud paysystem handler не может в момент оплаты передавать данные о товарах в корзине.
 * Их необходимо получить по rest
 * @package esas\cmsgate\wrappers
 */
class OrderWrapperBitrix24Cloud extends OrderWrapperCached
{
    protected $products;

    protected $restOrderData;
    protected $restShippingData;
    protected $restUserData;

    /**
     * @param OrderCache $orderCache
     */
    public function __construct($orderCache) {
        parent::__construct($orderCache);
        $orderId = $orderCache->getOrderData()[Bitrix24SaleOrder::ORDER_ID];
        $this->restOrderData = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api()->saleOrder()->get($orderId);
        $this->restShippingData = $this->restOrderData[Bitrix24SaleOrder::SHIPMENTS][0]; // todo check if only 1 item
        $userId = $this->restOrderData[Bitrix24SaleOrder::USER_ID];
        $this->restUserData = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api()->user()->get($userId);
    }

    /**
     * Уникальный идентификатор заказ в рамках CMS.
     * @return string
     */
    public function getOrderIdUnsafe() {
        return $this->restOrderData[Bitrix24SaleOrder::ORDER_ID];
    }

    /**
     * Полное имя покупателя
     * @return string
     */
    public function getFullNameUnsafe() {
        return trim($this->restUserData[Bitrix24User::FIRST_NAME] . ' ' . $this->restUserData[Bitrix24User::LAST_NAME]);
    }

    /**
     * Мобильный номер покупателя для sms-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getMobilePhoneUnsafe() {
        return $this->restUserData[Bitrix24User::PHONE];
    }

    /**
     * Email покупателя для email-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getEmailUnsafe() {
        return $this->restUserData[Bitrix24User::EMAIL];
    }

    /**
     * Физический адрес покупателя
     * @return string
     */
    public function getAddressUnsafe() {
        return $this->restUserData[Bitrix24User::PERSONAL_COUNTRY] . ' ' . $this->restUserData[Bitrix24User::PERSONAL_CITY]; //todo может стоит брать из shipping?

    }

    /**
     * Общая сумма товаров в заказе
     * @return string
     */
    public function getAmountUnsafe() {
        return $this->restOrderData[Bitrix24SaleOrder::PRICE];
    }


    public function getShippingAmountUnsafe() {
        if ($this->restShippingData != null && $this->restShippingData[Bitrix24SaleShipment::PRICE_DELIVERY] > 0)
            return $this->restShippingData[Bitrix24SaleShipment::PRICE_DELIVERY];
        return 0;
    }

    /**
     * Валюта заказа (буквенный код)
     * @return string
     */
    public function getCurrencyUnsafe() {
//        return 974; //todo
        return $this->restOrderData[Bitrix24SaleOrder::CURRENCY];
    }

    /**
     * Массив товаров в заказе
     * @return \esas\cmsgate\wrappers\OrderProductWrapperBitrix24Cloud[]
     */
    public function getProductsUnsafe() {
        if ($this->products != null)
            return $this->products;
        $items = $this->restOrderData[Bitrix24SaleOrder::BASKET_ITEMS];
        foreach ($items as $basketItem)
            $this->products[] = new OrderProductWrapperBitrix24Cloud($basketItem);
        return $this->products;
    }

    /**
     * Текущий статус заказа в CMS
     * @return mixed
     */
    public function getStatusUnsafe() {
        return new OrderStatus(
            $this->restOrderData[Bitrix24SaleOrder::STATUS_ID],
            $this->restOrderData[Bitrix24SaleOrder::STATUS_ID] //todo fix
        );
    }

    public function updateStatus($newOrderStatus) {
        parent::updateStatus($newOrderStatus);
    }


    /**
     * Идентификатор клиента
     * @return string
     */
    public function getClientIdUnsafe() {
        return $this->restOrderData[Bitrix24SaleOrder::USER_ID];
    }

}
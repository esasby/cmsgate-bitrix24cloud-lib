<?php

namespace esas\cmsgate\wrappers;

use esas\cmsgate\bridge\OrderCache;
use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\OrderStatus;
use esas\cmsgate\protocol\RequestParamsBitrix24Cloud;

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
    protected $paymentId;
    protected $restUserData;

    /**
     * @param OrderCache $orderCache
     */
    public function __construct($orderCache) {
        parent::__construct($orderCache);
        $orderId = $orderCache->getOrderData()[RequestParamsBitrix24Cloud::ORDER_ID];
        $this->paymentId = $orderCache->getOrderData()[RequestParamsBitrix24Cloud::PAYMENT_ID];
        $this->restOrderData = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api()->saleOrder()->get($orderId);
        $this->restUserData = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api()->crmContact()->get($this->restOrderData->getCrmContactId());
    }

    /**
     * Уникальный идентификатор заказ в рамках CMS.
     * @return string
     */
    public function getOrderIdUnsafe() {
        return $this->restOrderData->getId();
    }

    public function getPaymentIdUnsafe() {
        return $this->paymentId;
    }

    /**
     * Полное имя покупателя
     * @return string
     */
    public function getFullNameUnsafe() {
        return trim($this->restUserData->getName() . ' ' . $this->restUserData->getLastName());
    }

    /**
     * Мобильный номер покупателя для sms-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getMobilePhoneUnsafe() {
        return $this->restUserData->getPhone();
    }

    /**
     * Email покупателя для email-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getEmailUnsafe() {
        return $this->restUserData->getEmail();
    }

    /**
     * Физический адрес покупателя
     * @return string
     */
    public function getAddressUnsafe() {
//        if (is_array($this->restOrderData->getShipments())) {
//            $shipment = $this->restOrderData->getShipments()[0];
//            return $shipment->get
//        }
        return $this->restUserData->getAddressCountry() . ' ' . $this->restUserData->getAddressCity() . ' ' . $this->restUserData->getAddress();

    }

    /**
     * Общая сумма товаров в заказе
     * @return string
     */
    public function getAmountUnsafe() {
        return $this->restOrderData->getPrice();
    }


    public function getShippingAmountUnsafe() {
        if (is_array($this->restOrderData->getShipments()) && $this->restOrderData->getShipments()[0]->getPrice() > 0)
            return $this->restOrderData->getShipments()[0]->getPrice();
        return 0;
    }

    /**
     * Валюта заказа (буквенный код)
     * @return string
     */
    public function getCurrencyUnsafe() {
        return $this->restOrderData->getCurrency();
    }

    /**
     * Массив товаров в заказе
     * @return \esas\cmsgate\wrappers\OrderProductWrapperBitrix24Cloud[]
     */
    public function getProductsUnsafe() {
        if ($this->products != null)
            return $this->products;
        $items = $this->restOrderData->getItems();
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
            $this->restOrderData->getStatusId(),
            $this->restOrderData->getStatusId() //todo fix
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
        return $this->restOrderData->getUserId();
    }

}
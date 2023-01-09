<?php


namespace esas\cmsgate\protocol\bitrix24cloud;


use esas\cmsgate\bitrix\dto\sale\OrderConverter;

/**
 * Class SaleOrderApi
 * Список полей https://dev.1c-bitrix.ru/rest_help/sale/order/resource.php
 * @package esas\cmsgate\protocol
 */
class SaleOrderApi extends Bitrix24Api
{
    const ORDER_ID = 'id';
    const USER_ID = 'userId'; //todo проверить, что есть в ресурсе заказа, т.к. его нет в документации
    const PRICE = 'price';
    const CURRENCY = 'currency'; //todo проверить, что есть в ресурсе заказа, т.к. его нет в документации
    const STATUS_ID = 'statusId';
    const BASKET_ITEMS = 'basketItems';
    const SHIPMENTS = 'shipments';
    const PAYED = 'payed';

    public function get($id)
    {
        $result = $this->restClient->call('sale.order.get', ['id' => $id]);
        return OrderConverter::fromArray($result['result']['order']);
    }

    public function updateStatus($id, $newStatus, $setPaid = false)
    {
        $fields[self::STATUS_ID] = $newStatus;
        if ($setPaid)
            $fields[self::PAYED] = 'Y';
        $result = $this->restClient->call('sale.order.update', [
            'id' => $id,
            'fields' => $fields]);
        return $result['result'];
    }
}
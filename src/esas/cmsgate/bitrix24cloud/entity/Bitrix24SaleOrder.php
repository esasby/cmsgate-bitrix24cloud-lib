<?php


namespace esas\cmsgate\bitrix24cloud\entity;


use esas\cmsgate\CmsConnectorBitrix;
use esas\cmsgate\ConfigFields;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;

/**
 * Class Bitrix24SaleOrder
 * Список полей https://dev.1c-bitrix.ru/rest_help/sale/order/resource.php
 * @package esas\cmsgate\bitrix24cloud\entity
 */
class Bitrix24SaleOrder extends Bitrix24Entity
{
    const ORDER_ID = 'id';
    const USER_ID = 'userId'; //todo проверить, что есть в ресурсе заказа, т.к. его нет в документации
    const PRICE = 'price';
    const CURRENCY = 'currency'; //todo проверить, что есть в ресурсе заказа, т.к. его нет в документации
    const STATUS_ID = 'statusId';
    const BASKET_ITEMS = 'basketItems';
    const SHIPMENTS = 'shipments';

    public function get($id)
    {
        $result = $this->restClient->call('sale.order.get', $id);
        return $result['result'];
    }

    public function updateStatus($id, $newStatus)
    {
        $result = $this->restClient->call('sale.order.update', [
            'id' => $id,
            'fields' => [
                self::STATUS_ID => $newStatus
            ]]);
        return $result['result'];
    }

}
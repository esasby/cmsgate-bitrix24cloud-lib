<?php


namespace esas\cmsgate\bitrix\dto\sale;


class OrderItemConverter
{
    public static function fromArray($dataArray) {
        $orderItem = new OrderItem();
        $orderItem
            ->setId($dataArray['id'])
            ->setProductId($dataArray['productId'])
            ->setOrderId($dataArray['orderId'])
            ->setName($dataArray['name'])
            ->setQuantity($dataArray['quantity'])
            ->setUnitPrice($dataArray['price']);
        return $orderItem;
    }

    /**
     * @param $order OrderItem
     * @return array
     */
    public static function toArray($order) {
        $fields = [
            'id' => $order->getId(),
            'productId' => $order->getProductId(),
            'orderId' => $order->getOrderId(),
            'name' => $order->getName(),
            'quantity' => $order->getQuantity(),
            'price' => $order->getUnitPrice()
        ];
        return $fields;
    }
}
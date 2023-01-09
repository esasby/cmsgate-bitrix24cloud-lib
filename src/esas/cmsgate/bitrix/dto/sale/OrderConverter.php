<?php


namespace esas\cmsgate\bitrix\dto\sale;


class OrderConverter
{
    public static function fromArray($dataArray) {
        $order = new Order();
        $order
            ->setId($dataArray['id'])
            ->setStatusId($dataArray['statusId'])
            ->setUserId($dataArray['userId'])
            ->setCrmContactId($dataArray['clients'][0]['entityId']) //todo try/catch
            ->setPrice($dataArray['price'])
            ->setCurrency($dataArray['currency']);
        $items = array();
        foreach ($dataArray['basketItems'] as $basketItemDataArray) {
            $items[] = OrderItemConverter::fromArray($basketItemDataArray);
        }
        $order->setItems($items);
        $shipments = array();
        foreach ($dataArray['shipments'] as $shipmentDataArray) {
            $shipments[] = ShipmentConverter::fromArray($shipmentDataArray);
        }
        $order->setShipments($shipments);
        return $order;
    }

    /**
     * @param $order Order
     * @return array
     */
    public static function toArray($order) {
        $fields = [
            'id' => $order->getId(),
            'statusId' => $order->getStatusId(),
            'price' => $order->getPrice(),
            'currency' => $order->getCurrency()
            //todo items
        ];
        return $fields;
    }
}
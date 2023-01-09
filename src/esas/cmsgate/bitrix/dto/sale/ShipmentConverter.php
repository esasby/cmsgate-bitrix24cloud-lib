<?php


namespace esas\cmsgate\bitrix\dto\sale;


class ShipmentConverter
{
    public static function fromArray($dataArray) {
        $shipment = new Shipment();
        $shipment
            ->setId($dataArray['id'])
            ->setOrderId($dataArray['orderId'])
            ->setStatusId($dataArray['statusId'])
            ->setDeliveryId($dataArray['deliveryId'])
            ->setDeliveryName($dataArray['deliveryName'])
            ->setPrice($dataArray['priceDelivery'])
            ->setCurrency($dataArray['currency']);
        return $shipment;
    }

    /**
     * @param $shipment Shipment
     * @return array
     */
    public static function toArray($shipment) {
        $fields = [
            'id' => $shipment->getId(),
            'orderId' => $shipment->getOrderId(),
            'statusId' => $shipment->getStatusId(),
            'priceDelivery' => $shipment->getPrice(),
            'currency' => $shipment->getCurrency(),
            'deliveryId' => $shipment->getDeliveryId(),
            'deliveryName' => $shipment->getDeliveryName()
        ];
        return $fields;
    }
}
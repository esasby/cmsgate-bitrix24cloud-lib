<?php


namespace esas\cmsgate\bitrix\dto\sale;


class Shipment
{
    private $id;
    private $deliveryId;
    private $deliveryName;
    private $price;
    private $currency;
    private $orderId;
    private $statusId;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Shipment
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeliveryId() {
        return $this->deliveryId;
    }

    /**
     * @param mixed $deliveryId
     * @return Shipment
     */
    public function setDeliveryId($deliveryId) {
        $this->deliveryId = $deliveryId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeliveryName() {
        return $this->deliveryName;
    }

    /**
     * @param mixed $deliveryName
     * @return Shipment
     */
    public function setDeliveryName($deliveryName) {
        $this->deliveryName = $deliveryName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return Shipment
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     * @return Shipment
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId() {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     * @return Shipment
     */
    public function setOrderId($orderId) {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusId() {
        return $this->statusId;
    }

    /**
     * @param mixed $statusId
     * @return Shipment
     */
    public function setStatusId($statusId) {
        $this->statusId = $statusId;
        return $this;
    }
}
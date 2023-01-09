<?php


namespace esas\cmsgate\bitrix\dto\sale;


class Order
{
    private $id;
    private $statusId;
    private $price;
    private $currency;
    private $crmContactId;
    private $userId;
    /**
     * @var OrderItem[]
     */
    private $items;
    /**
     * @var Shipment[]
     */
    private $shipments;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Order
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return Order
     */
    public function setStatusId($statusId) {
        $this->statusId = $statusId;
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
     * @return Order
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
     * @return Order
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return Order
     */
    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCrmContactId() {
        return $this->crmContactId;
    }

    /**
     * @param mixed $crmContactId
     * @return Order
     */
    public function setCrmContactId($crmContactId) {
        $this->crmContactId = $crmContactId;
        return $this;
    }



    /**
     * @return OrderItem[]
     */
    public function getItems(): array {
        return $this->items;
    }

    /**
     * @param OrderItem[] $items
     * @return Order
     */
    public function setItems(array $items): Order {
        $this->items = $items;
        return $this;
    }

    /**
     * @return Shipment[]
     */
    public function getShipments(): array {
        return $this->shipments;
    }

    /**
     * @param Shipment[] $shipments
     * @return Order
     */
    public function setShipments(array $shipments): Order {
        $this->shipments = $shipments;
        return $this;
    }


}
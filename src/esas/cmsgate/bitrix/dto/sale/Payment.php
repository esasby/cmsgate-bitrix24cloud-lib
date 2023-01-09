<?php


namespace esas\cmsgate\bitrix\dto\sale;


class Payment
{
    private $id;
    private $orderId;
    /**
     * @var boolean
     */
    private $paid;
    private $paysystemId;
    private $paysystemStatus;
    private $paysystemInvoiceId;
    private $amount;
    private $currency;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Payment
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return Payment
     */
    public function setOrderId($orderId) {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPaid(): bool {
        return $this->paid;
    }

    /**
     * @param bool $paid
     * @return Payment
     */
    public function setPaid(bool $paid): Payment {
        $this->paid = $paid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaysystemId() {
        return $this->paysystemId;
    }

    /**
     * @param mixed $paysystemId
     * @return Payment
     */
    public function setPaysystemId($paysystemId) {
        $this->paysystemId = $paysystemId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaysystemStatus() {
        return $this->paysystemStatus;
    }

    /**
     * @param mixed $paysystemStatus
     * @return Payment
     */
    public function setPaysystemStatus($paysystemStatus) {
        $this->paysystemStatus = $paysystemStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaysystemInvoiceId() {
        return $this->paysystemInvoiceId;
    }

    /**
     * @param mixed $paysystemInvoiceId
     * @return Payment
     */
    public function setPaysystemInvoiceId($paysystemInvoiceId) {
        $this->paysystemInvoiceId = $paysystemInvoiceId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     * @return Payment
     */
    public function setAmount($amount) {
        $this->amount = $amount;
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
     * @return Payment
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }


}
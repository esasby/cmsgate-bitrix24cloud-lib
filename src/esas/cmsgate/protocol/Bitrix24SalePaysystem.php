<?php


namespace esas\cmsgate\bitrix24cloud\entity;


use esas\cmsgate\utils\CMSGateException;

class Bitrix24SalePaysystem extends Bitrix24Entity
{
    /**
     * @throws CmsgateException
     * @return boolean
     */
    public function add($fields)
    {
        $result = $this->restClient->call('sale.paysystem.add', $fields);
        return $result['result'];
    }

    /**
     * @throws CmsgateException
     * @return boolean
     */
    public function update($id, $fields)
    {
        $result = $this->restClient->call('sale.paysystem.update', [
            'id' => $id,
            'fields' => $fields]);
        return $result['result'];
    }

    /**
     * @throws CmsgateException
     * @return array
     */
    public function get($select, $filter)
    {
        $result = $this->restClient->call('sale.paysystem.list', [
            'select' => $select,
            'filter' => $filter]);
        return $result['result'];
    }

    public function getById($id) {
        return $this->get('*', ['id' => $id])[0]; //todo check
    }

    public function getSettingsForPayment($paymentId, $psId) {
        $result = $this->restClient->call('sale.paysystem.settings.payment.get', [
            'payment_id' => $paymentId,
            'PAY_SYSTEM_ID' => $psId]);
        return $result['result'];
    }

    /**
     * @throws CmsgateException
     * @return array
     */
    public function list($select, $filter = null)
    {
        $result = $this->restClient->call('sale.paysystem.list', [
            'select' => $select,
            'filter' => $filter]);
        return $result['result'];
    }

    /**
     * @throws CmsgateException
     * @return boolean
     */
    public function handlerAdd($fields)
    {
        $result = $this->restClient->call('sale.paysystem.handler.add', $fields);
        return $result['result'];
    }
}
<?php


namespace esas\cmsgate\protocol\bitrix24cloud;

use esas\cmsgate\utils\CMSGateException;

class SaleStatusApi extends Bitrix24Api
{
    /**
     * @throws CmsgateException
     * @return array
     */
    public function list($filter = null)
    {
        $result = $this->restClient->call('sale.status.list', array(
            "filter" => $filter
        ));
        return $result['result']['statuses'];
    }

    public function listForOrder()
    {
        return $this->list(array("type" => "O"));
    }

    public function listForDelivery()
    {
        return $this->list(array("type" => "D"));
    }
}
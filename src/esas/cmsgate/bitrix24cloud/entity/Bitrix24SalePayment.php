<?php


namespace esas\cmsgate\bitrix24cloud\entity;


use esas\cmsgate\CmsConnectorBitrix;
use esas\cmsgate\ConfigFields;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;

class Bitrix24SalePayment extends Bitrix24Entity
{
    /**
     * @throws CmsgateException
     * @return array
     */
    public function get($id)
    {
        $result = $this->restClient->call('sale.payment.get', [
            'id' => $id]);
        return $result['result'];
    }

}
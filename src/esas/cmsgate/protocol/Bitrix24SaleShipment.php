<?php


namespace esas\cmsgate\bitrix24cloud\entity;


use esas\cmsgate\CmsConnectorBitrix;
use esas\cmsgate\ConfigFields;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;

class Bitrix24SaleShipment extends Bitrix24Entity
{
    const PRICE_DELIVERY = 'priceDelivery';
    const DELIVERY_NAME = 'deliveryName';
    /**
     * @throws CmsgateException
     * @return array
     */
    public function get($id)
    {
        $result = $this->restClient->call('ale.shipment.get', [
            'id' => $id]);
        return $result['result'];
    }

}
<?php


namespace esas\cmsgate\protocol\bitrix24cloud;

use esas\cmsgate\utils\CMSGateException;

class SaleShipmentApi extends Bitrix24Api
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
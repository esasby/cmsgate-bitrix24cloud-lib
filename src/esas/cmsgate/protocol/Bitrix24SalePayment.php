<?php


namespace esas\cmsgate\bitrix24cloud\entity;


use esas\cmsgate\CmsConnectorBitrix;
use esas\cmsgate\ConfigFields;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;

class Bitrix24SalePayment extends Bitrix24Entity
{
    const PS_STATUS_ID = 'psStatus';
    const PS_INVOICE_ID = 'psInvoiceId';

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

    public function update($id, $newStatus, $extId)
    {
        $result = $this->restClient->call('sale.payment.update', [
            'id' => $id,
            'fields' => [
                self::PS_STATUS_ID => $newStatus,
                self::PS_INVOICE_ID => $extId
            ]]);
        return $result['result'];
    }

}
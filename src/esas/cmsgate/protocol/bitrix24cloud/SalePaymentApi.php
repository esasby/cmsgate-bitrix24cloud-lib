<?php


namespace esas\cmsgate\protocol\bitrix24cloud;

use esas\cmsgate\bitrix\dto\sale\Payment;
use esas\cmsgate\bitrix\dto\sale\PaymentConverter;
use esas\cmsgate\utils\CMSGateException;

class SalePaymentApi extends Bitrix24Api
{
    const PS_ID = 'paySystemId';
    const PS_STATUS_ID = 'psStatus';
    const PS_INVOICE_ID = 'psInvoiceId';
    const PAID = 'paid';

    /**
     * @return Payment
     * @throws CmsgateException
     */
    public function get($id) {
        $result = $this->restClient->call('sale.payment.get', [
            'id' => $id]);
        return PaymentConverter::fromArray($result['result']['payment']);
    }

    public function updateStatus($id, $newStatus, $setPaid = false) {
        $fields = [
            self::PS_STATUS_ID => $newStatus,
            self::PS_ID => $this->getPaysystemId($id)];
        if ($setPaid)
            $fields[self::PAID] = 'Y';
        $result = $this->restClient->call('sale.payment.update', [
            'id' => $id,
            'fields' => $fields]);
        return $result['result'];
    }

    public function saveExtId($id, $extId) {
        $result = $this->restClient->call('sale.payment.update', [
            'id' => $id,
            'fields' => [
                self::PS_ID => $this->getPaysystemId($id),
                self::PS_INVOICE_ID => $extId
            ]]);
        return $result['result'];
    }

    private function getPaysystemId($id) {
        $result = $this->restClient->call('sale.payment.get', [
            'id' => $id]);
        return $result['result']['payment'][self::PS_ID];
    }

}
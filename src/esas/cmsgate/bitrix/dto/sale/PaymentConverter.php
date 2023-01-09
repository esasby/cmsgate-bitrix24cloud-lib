<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaymentConverter
{
    public static function fromArray($dataArray) {
        $payment = new Payment();
        $payment
            ->setId($dataArray['id'])
            ->setPaysystemId($dataArray['paySystemId'])
            ->setPaysystemInvoiceId($dataArray['psInvoiceId'])
            ->setPaysystemStatus($dataArray['psStatus'])
            ->setPaid($dataArray['paid'] == 'Y')
            ->setAmount($dataArray['sum'])
            ->setCurrency($dataArray['currency']);
        return $payment;
    }

    /**
     * @param $payment Payment
     * @return array
     */
    public static function toArray($payment) {
        $fields = [
            'id' => $payment->getId(),
            'paySystemId' => $payment->getPaysystemId(),
            'psInvoiceId' => $payment->getPaysystemInvoiceId(),
            'psStatus' => $payment->getPaysystemStatus(),
            'paid' => $payment->isPaid() ? 'Y' : 'N',
            'sum' => $payment->getAmount(),
            'currency' => $payment->getCurrency()
        ];
        return $fields;
    }
}
<?php


namespace esas\cmsgate\bitrix\dto\sale;


use esas\cmsgate\utils\CMSGateException;

class CrmContactConverter
{
    public static function fromArray($dataArray) {
        $crmContact = new CrmContact();
        $crmContact
            ->setId($dataArray['ID'])
            ->setName($dataArray['NAME'])
            ->setLastName($dataArray['LAST_NAME'])
            ->setSecondName($dataArray['SECOND_NAME'])
            ->setAddressCountry($dataArray['ADDRESS_COUNTRY'])
            ->setAddressRegion($dataArray['ADDRESS_REGION'])
            ->setAddressProvince($dataArray['ADDRESS_PROVINCE'])
            ->setAddressCity($dataArray['ADDRESS_CITY'])
            ->setAddressPostalCode($dataArray['ADDRESS_POSTAL_CODE'])
            ->setAddress($dataArray['ADDRESS'])
            ;
        if (is_array($dataArray['EMAIL']))
            $crmContact->setEmail($dataArray['EMAIL'][0]['VALUE']);
        if (is_array($dataArray['PHONE']))
            $crmContact->setPhone($dataArray['PHONE'][0]['VALUE']);
        return $crmContact;
    }

    /**
     * @param $crmContact CrmContact
     * @return array
     */
    public static function toArray($crmContact) {
        throw new CMSGateException('Not implemented');
    }
}
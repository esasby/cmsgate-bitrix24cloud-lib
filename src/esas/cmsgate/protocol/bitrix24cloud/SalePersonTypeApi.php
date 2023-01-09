<?php


namespace esas\cmsgate\protocol\bitrix24cloud;

use esas\cmsgate\bitrix\dto\sale\PersonType;
use esas\cmsgate\bitrix\dto\sale\PersonTypeConverter;
use esas\cmsgate\utils\CMSGateException;

class SalePersonTypeApi extends Bitrix24Api
{
    /**
     * @throws CmsgateException
     * @return PersonType[]
     */
    public function list($filter = null)
    {
        $result = $this->restClient->call('sale.persontype.list', array(
            "filter" => $filter
        ));
        $personTypes = array();
        foreach ($result['result']['personTypes'] as $dataArray)
            $personTypes[] = PersonTypeConverter::fromArray($dataArray);
        return $personTypes;
    }

    public function getForCRMContcat() {
        return $this->list(['code' => 'CRM_CONTACT'])[0];
    }
}
<?php


namespace esas\cmsgate\protocol\bitrix24cloud;

use esas\cmsgate\bitrix\dto\sale\CrmContactConverter;

class CrmContactApi extends Bitrix24Api
{
    public function get($id)
    {
        $result = $this->restClient->call('crm.contact.get', [
            'id' => $id
        ]);
        return CrmContactConverter::fromArray($result['result']);
    }

}
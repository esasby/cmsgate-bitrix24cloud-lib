<?php


namespace esas\cmsgate\bitrix24cloud\entity;


use esas\cmsgate\CmsConnectorBitrix;
use esas\cmsgate\ConfigFields;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;

class Bitrix24User extends Bitrix24Entity
{
    const FIRST_NAME = 'NAME';
    const LAST_NAME = 'LAST_NAME';
    const EMAIL = 'EMAIL';
    const PHONE = 'PERSONAL_PHONE';
    const PERSONAL_CITY = 'PERSONAL_CITY';
    const PERSONAL_STATE = 'PERSONAL_STATE';
    const PERSONAL_COUNTRY = 'PERSONAL_COUNTRY';


    public function get($id)
    {
        $result = $this->restClient->call('user.get', [
            'ID' => $id
        ]);
        return $result['result'];
    }

}
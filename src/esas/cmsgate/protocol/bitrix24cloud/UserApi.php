<?php


namespace esas\cmsgate\protocol\bitrix24cloud;

use esas\cmsgate\bitrix\dto\sale\UserConverter;

class UserApi extends Bitrix24Api
{
    public function get($id)
    {
        $result = $this->restClient->call('user.get', [
            'ID' => $id
        ]);
        return UserConverter::fromArray($result['result']['user']);
    }

}
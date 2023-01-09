<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PersonTypeConverter
{
    public static function fromArray($dataArray) {
        $personType = new PersonType();
        $personType
            ->setCode($dataArray['code'])
            ->setId($dataArray['id'])
            ->setName($dataArray['name'])
            ->setActive($dataArray['active'] == 'Y')
            ->setSort($dataArray['sort']);
        return $personType;
    }

    /**
     * @param $personType PersonType
     * @return array
     */
    public static function toArray($personType) {
        $fields = [
            'NAME' => $personType->getName(),
            'CODE' => $personType->getCode(),
            'SORT' => $personType->getSort(),
            'ACTIVE' => $personType->isActive() ? 'Y' : 'N'
        ];
        return $fields;
    }
}
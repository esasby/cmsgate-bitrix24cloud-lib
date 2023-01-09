<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaysystemHandlerConverter
{
    public static function fromArray($dataArray) {
        $handler = new PaysystemHandler();
        $handler
            ->setCode($dataArray['CODE'])
            ->setId($dataArray['ID'])
            ->setName($dataArray['NAME'])
            ->setSort($dataArray['SORT'])
            ->setSettings(PaysystemHandlerSettingsConverter::fromArray($dataArray['SETTINGS']));
        return $handler;
    }

    /**
     * @param $paysystemHandler PaysystemHandler
     * @return array
     */
    public static function toArray($paysystemHandler) {
        $fields = [
            'NAME' => $paysystemHandler->getName(),
            'CODE' => $paysystemHandler->getCode(),
            'SORT' => $paysystemHandler->getSort(),
            'SETTINGS' => PaysystemHandlerSettingsConverter::toArray($paysystemHandler->getSettings())
        ];
        return $fields;
    }
}
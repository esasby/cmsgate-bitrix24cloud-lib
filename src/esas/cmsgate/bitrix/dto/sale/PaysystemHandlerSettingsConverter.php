<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaysystemHandlerSettingsConverter
{
    public static function fromArray($dataArray) {
        $settings = new PaysystemHandlerSettings();
        $settings
            ->setCurrency($dataArray['CURRENCY'])
            ->setFormData(PaysystemHandlerSettingsFormDataConverter::fromArray($dataArray['FORM_DATA']))
            ->addConfigFieldsFromArray($dataArray['CODES']);
        return $settings;
    }

    /**
     * @param $settings PaysystemHandlerSettings
     * @return array
     */
    public static function toArray($settings) {
        $codes = array();
        foreach ($settings->getConfigFields() as $field) {
            $codes[$field->getKey()] = PaysystemHandlerSettingsConfigFieldConverter::toArray($field);
        }
        $ret = [
            'CURRENCY' => $settings->getCurrency(),
            'FORM_DATA' => PaysystemHandlerSettingsFormDataConverter::toArray($settings->getFormData()),
            'CODES' => $codes
        ];
        return $ret;
    }


}
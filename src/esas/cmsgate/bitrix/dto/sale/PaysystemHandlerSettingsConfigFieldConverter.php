<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaysystemHandlerSettingsConfigFieldConverter
{

    public static function fromArray($fieldKey, $fieldsDataArray) {
        $field = new PaysystemHandlerSettingsConfigField();
        $field
            ->setKey($fieldKey)
            ->setName($fieldsDataArray['NAME'])
            ->setDescription($fieldsDataArray['DESCRIPTION'])
            ->setSort($fieldsDataArray['SORT'])
            ->setGroup($fieldsDataArray['GROUP']);
        if (in_array('INPUT', $fieldsDataArray))
            $field->setType($fieldsDataArray['INPUT']['TYPE']);
        if (in_array('DEFAULT', $fieldsDataArray)) {
            $field
                ->setDefaultProviderKey($fieldsDataArray['DEFAULT']['PROVIDER_KEY'])
                ->setDefaultProviderValue($fieldsDataArray['DEFAULT']['PROVIDER_VALUE']);
        }
        return $field;
    }

    /**
     * @param $field PaysystemHandlerSettingsConfigField
     * @return mixed
     */
    public static function toArray($field) {
        $ret['NAME'] = $field->getName() . ($field->isRequired() ? '*' : '');
        if (!empty($field->getSort()))
            $ret['SORT'] = $field->getSort();
        if (!empty($field->getDescription()))
            $ret['DESCRIPTION'] = $field->getDescription();
        if (!empty($field->getGroup()))
            $ret['GROUP'] = $field->getGroup();
        if (!empty($field->getDefaultProviderKey()))
            $ret['DEFAULT']['PROVIDER_KEY'] = $field->getDefaultProviderKey();
        if (!empty($field->getDefaultProviderValue()))
            $ret['DEFAULT']['PROVIDER_VALUE'] = $field->getDefaultProviderValue();
        if (!empty($field->getType()))
            $ret['INPUT']['TYPE'] = $field->getType();
        if (is_array($field->getTypeEnumOptions())) {
            $ret['INPUT']['OPTIONS'] = $field->getTypeEnumOptions();
        }
        return $ret;
    }

}
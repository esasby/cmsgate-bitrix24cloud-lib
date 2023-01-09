<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaysystemHandlerSettingsFormDataFieldConverter
{
    public static function fromArray($fieldKey, $dataArray) {
        $field = new PaysystemHandlerSettingsFormDataField();
        $field
            ->setRequestFieldKey($fieldKey)
            ->setVisible($dataArray['VISIBLE'] == 'Y');
        if (is_array($dataArray['CODE']))
            $field
                ->setName($dataArray['CODE']['NAME'])
                ->setType($dataArray['CODE']['TYPE']);
        else
            $field
                ->setConfigFieldKey($dataArray['CODE']);
        return $field;
    }

    /**
     * @param $field PaysystemHandlerSettingsFormDataField
     * @return mixed
     */
    public static function toArray($field) {
        $ret['VISIBLE'] = $field->isVisible() ? 'Y' : 'N';
        if (!empty($field->getConfigFieldKey()))
            $ret['CODE'] = $field->getConfigFieldKey();
        if (!empty($field->getName()))
            $ret['CODE']['NAME'] = $field->getName();
        if (!empty($field->getType()))
            $ret['CODE']['TYPE'] = $field->getType();
        return $ret;
    }

}
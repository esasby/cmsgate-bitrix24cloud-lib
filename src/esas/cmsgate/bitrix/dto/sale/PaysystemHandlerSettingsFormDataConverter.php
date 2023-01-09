<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaysystemHandlerSettingsFormDataConverter
{
    public static function fromArray($dataArray) {
        $formData = new PaysystemHandlerSettingsFormData();
        $formData
            ->setActionUrl($dataArray['ACTION_URI'])
            ->setMethod($dataArray['METHOD']);
        $fields = array();
        foreach ($dataArray['FIELDS'] as $fieldKey => $fieldsDataArray) {
            $fields[] = PaysystemHandlerSettingsFormDataFieldConverter::fromArray($fieldKey, $fieldsDataArray);
        }
        $formData->setFields($fields);
        return $formData;
    }

    /**
     * @param $formData PaysystemHandlerSettingsFormData
     * @return array
     */
    public static function toArray($formData) {
        $fields = array();
        foreach ($formData->getFields() as $field) {
            $fields[$field->getRequestFieldKey()] = PaysystemHandlerSettingsFormDataFieldConverter::toArray($field);
        }
        $ret = [
            'ACTION_URI' => $formData->getActionUrl(),
            'METHOD' => $formData->getMethod(),
            'FIELDS' => $fields
        ];
        return $ret;
    }
}
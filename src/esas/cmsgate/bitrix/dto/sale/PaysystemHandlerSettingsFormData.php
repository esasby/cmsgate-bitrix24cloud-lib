<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaysystemHandlerSettingsFormData
{
    private $actionUrl;
    private $method;

    /**
     * @var PaysystemHandlerSettingsFormDataField[]
     */
    private $fields;

    public static function newInstance() {
        return new PaysystemHandlerSettingsFormData();
    }

    /**
     * @return mixed
     */
    public function getActionUrl() {
        return $this->actionUrl;
    }

    /**
     * @param mixed $actionUrl
     * @return PaysystemHandlerSettingsFormData
     */
    public function setActionUrl($actionUrl) {
        $this->actionUrl = $actionUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return PaysystemHandlerSettingsFormData
     */
    public function setMethod($method) {
        $this->method = $method;
        return $this;
    }

    /**
     * @return PaysystemHandlerSettingsFormDataField[]
     */
    public function getFields(): array {
        return $this->fields;
    }

    /**
     * @param PaysystemHandlerSettingsFormDataField[] $fields
     * @return PaysystemHandlerSettingsFormData
     */
    public function setFields(array $fields) {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @param PaysystemHandlerSettingsFormDataField $field
     * @return PaysystemHandlerSettingsFormData
     */
    public function addField($field) {
        $this->fields[] = $field;
        return $this;
    }



}
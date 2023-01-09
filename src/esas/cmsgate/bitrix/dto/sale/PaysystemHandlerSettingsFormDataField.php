<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaysystemHandlerSettingsFormDataField
{
    private $requestFieldKey;
    private $configFieldKey;
    private $name;
    private $type;
    /**
     * @var boolean
     */
    private $visible;

    public static function newInstance() {
        return new PaysystemHandlerSettingsFormDataField();
    }

    /**
     * @return mixed
     */
    public function getRequestFieldKey() {
        return $this->requestFieldKey;
    }

    /**
     * @param mixed $requestFieldKey
     * @return PaysystemHandlerSettingsFormDataField
     */
    public function setRequestFieldKey($requestFieldKey) {
        $this->requestFieldKey = $requestFieldKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfigFieldKey() {
        return $this->configFieldKey;
    }

    /**
     * @param mixed $configFieldKey
     * @return PaysystemHandlerSettingsFormDataField
     */
    public function setConfigFieldKey($configFieldKey) {
        $this->configFieldKey = $configFieldKey;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return PaysystemHandlerSettingsFormDataField
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return PaysystemHandlerSettingsFormDataField
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool {
        return $this->visible;
    }

    /**
     * @param bool $visible
     * @return PaysystemHandlerSettingsFormDataField
     */
    public function setVisible(bool $visible) {
        $this->visible = $visible;
        return $this;
    }



}
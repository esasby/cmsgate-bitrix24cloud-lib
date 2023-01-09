<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaysystemHandlerSettings
{
    private $currency;
    /**
     * @var PaysystemHandlerSettingsFormData
     */
    private $formData;
    /**
     * @var PaysystemHandlerSettingsConfigField[]
     */
    private $configFields;

    public static function newInstance() {
        return new PaysystemHandlerSettings();
    }

    /**
     * @return mixed
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     * @return PaysystemHandlerSettings
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return PaysystemHandlerSettingsFormData
     */
    public function getFormData(): PaysystemHandlerSettingsFormData {
        return $this->formData;
    }

    /**
     * @param PaysystemHandlerSettingsFormData $formData
     * @return PaysystemHandlerSettings
     */
    public function setFormData(PaysystemHandlerSettingsFormData $formData) {
        $this->formData = $formData;
        return $this;
    }

    /**
     * @return PaysystemHandlerSettingsConfigField[]
     */
    public function getConfigFields(): array {
        return $this->configFields;
    }

    /**
     * @param PaysystemHandlerSettingsConfigField[] $configFields
     * @return PaysystemHandlerSettings
     */
    public function setConfigFields(array $configFields) {
        $this->configFields = $configFields;
        return $this;
    }

    /**
     * @param PaysystemHandlerSettingsConfigField $field
     * @return PaysystemHandlerSettings
     */
    public function addConfigField($configField) {
        $this->configFields[] = $configField;
        return $this;
    }

    public function addConfigFieldsFromArray($configFieldsArray) {
        foreach ($configFieldsArray as $configFieldKey => $configFieldArray) {
            $this->configFields[] = PaysystemHandlerSettingsConfigFieldConverter::fromArray($configFieldKey, $configFieldArray);
        }
        return $this;
    }


}
<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaysystemHandlerSettingsConfigField
{
    private $key;
    private $name;
    private $description;
    private $type;
    private $typeEnumOptions;
    private $sort;
    private $group;
    /**
     * @var boolean
     */
    private $required = false;
    private $defaultProviderKey;
    private $defaultProviderValue;

    public static function newInstance() {
        return new PaysystemHandlerSettingsConfigField();
    }

    /**
     * @return mixed
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * @param mixed $key
     * @return PaysystemHandlerSettingsConfigField
     */
    public function setKey($key) {
        $this->key = $key;
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
     * @return PaysystemHandlerSettingsConfigField
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return PaysystemHandlerSettingsConfigField
     */
    public function setDescription($description) {
        $this->description = $description;
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
     * @return PaysystemHandlerSettingsConfigField
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeEnumOptions() {
        return $this->typeEnumOptions;
    }

    /**
     * @param mixed $typeEnumOptions
     * @return PaysystemHandlerSettingsConfigField
     */
    public function setTypeEnumOptions($typeEnumOptions) {
        $this->typeEnumOptions = $typeEnumOptions;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getSort() {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     * @return PaysystemHandlerSettingsConfigField
     */
    public function setSort($sort) {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroup() {
        return $this->group;
    }

    /**
     * @param mixed $group
     * @return PaysystemHandlerSettingsConfigField
     */
    public function setGroup($group) {
        $this->group = $group;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired() {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return PaysystemHandlerSettingsConfigField
     */
    public function setRequired($required) {
        $this->required = $required;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultProviderKey() {
        return $this->defaultProviderKey;
    }

    /**
     * @param mixed $defaultProviderKey
     * @return PaysystemHandlerSettingsConfigField
     */
    public function setDefaultProviderKey($defaultProviderKey) {
        $this->defaultProviderKey = $defaultProviderKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultProviderValue() {
        return $this->defaultProviderValue;
    }

    /**
     * @param mixed $defaultProviderValue
     * @return PaysystemHandlerSettingsConfigField
     */
    public function setDefaultProviderValue($defaultProviderValue) {
        $this->defaultProviderValue = $defaultProviderValue;
        return $this;
    }


}
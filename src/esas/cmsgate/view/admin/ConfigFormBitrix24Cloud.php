<?php

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 30.09.2018
 * Time: 15:19
 */

namespace esas\cmsgate\view\admin;

use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\ConfigFieldsBitrix24Cloud;
use esas\cmsgate\bitrix\dto\sale\PaysystemHandlerSettingsConfigField;
use esas\cmsgate\view\admin\fields\ConfigField;
use esas\cmsgate\view\admin\fields\ConfigFieldCheckbox;
use esas\cmsgate\view\admin\fields\ConfigFieldList;
use esas\cmsgate\view\admin\fields\ConfigFieldText;
use esas\cmsgate\view\admin\fields\ListOption;


class ConfigFormBitrix24Cloud extends ConfigFormArray
{
    protected $orderStatuses;

    /**
     * @return PaysystemHandlerSettingsConfigField[]
     */
    public function generate() {
        return parent::generate();
    }

    public function createStatusListOptions() {
        if ($this->orderStatuses == null) {
            $bitrixStatusList = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(false)->saleStatus()->listForOrder();
            foreach($bitrixStatusList as $status) {
                $statusKey = $status["id"];
                $statusName = $status["name"];
                $this->orderStatuses[$statusKey] = new ListOption($statusKey, '[' . $statusKey . '] ' .  $statusName);
            }
        }
        return $this->orderStatuses;
    }


    /**
     * @return $this
     */
    public function addCmsDefaultFields()
    {
        $this->managedFields->addField(new ConfigFieldText(ConfigFieldsBitrix24Cloud::returnUrlSuccess()));
        $this->managedFields->addField(new ConfigFieldText(ConfigFieldsBitrix24Cloud::returnUrlFailed()));
        return $this;
    }

    function generateTextField(ConfigField $configField) {
        $bitrixConfigField = $this->createBitrixConfigField($configField);
        $bitrixConfigField->setType('STRING');
        return $bitrixConfigField;
    }

    public function generateCheckboxField(ConfigFieldCheckbox $configField)
    {
        $bitrixConfigField = $this->createBitrixConfigField($configField);
        $bitrixConfigField->setType('Y/N');
        return $bitrixConfigField;
    }

    public function generateListField(ConfigFieldList $configField)
    {
        $bitrixConfigField = $this->createBitrixConfigField($configField);
        $options = array();
        foreach ($configField->getOptions() as $option)
            $options[$option->getValue()] = $option->getName();
        $bitrixConfigField->setType('ENUM');
        $bitrixConfigField->setTypeEnumOptions($options);
        return $bitrixConfigField;
    }

    public function createBitrixConfigField(ConfigField $configField, $addDefault = true)
    {
        $bitrixConfigField = new PaysystemHandlerSettingsConfigField();
        $bitrixConfigField
            ->setName($configField->getName())
            ->setKey($configField->getKey())
            ->setDescription($configField->getDescription())
            ->setSort($configField->getSortOrder())
            ->setGroup($this->getFormKey());

        if ($addDefault && $configField->hasDefault()) {
            $bitrixConfigField->setDefaultProviderKey('VALUE');
            $bitrixConfigField->setDefaultProviderValue($configField->getDefault());
        }
        return $bitrixConfigField;
    }
}
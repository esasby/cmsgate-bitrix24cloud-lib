<?php

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 30.09.2018
 * Time: 15:19
 */

namespace esas\cmsgate\view\admin;

use esas\cmsgate\ConfigFieldsBitrix24Cloud;
use esas\cmsgate\view\admin\fields\ConfigFieldText;


class ConfigFormBitrix24Cloud extends ConfigFormBitrix
{
    public function __construct($formKey, $managedFields) {
        parent::__construct($formKey, $managedFields);
        $this->addCmsDefaultFields();
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
}
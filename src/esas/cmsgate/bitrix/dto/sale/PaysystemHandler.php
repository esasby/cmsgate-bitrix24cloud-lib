<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PaysystemHandler
{
    private $id;
    private $name;
    private $code;
    private $sort;
    /**
     * @var PaysystemHandlerSettings
     */
    private $settings;

    public static function newInstance() {
        return new PaysystemHandler();
    }
    
    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return PaysystemHandler
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return PaysystemHandler
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return PaysystemHandler
     */
    public function setCode($code) {
        $this->code = $code;
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
     * @return PaysystemHandler
     */
    public function setSort($sort) {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return PaysystemHandlerSettings
     */
    public function getSettings() {
        return $this->settings;
    }

    /**
     * @param PaysystemHandlerSettings $settings
     * @return PaysystemHandler
     */
    public function setSettings(PaysystemHandlerSettings $settings) {
        $this->settings = $settings;
        return $this;
    }


}
<?php


namespace esas\cmsgate\bitrix\dto\sale;


class PersonType
{
    private $id;
    private $name;
    private $code;
    private $sort;
    /**
     * @var boolean
     */
    private $active;

    public static function newInstance() {
        return new PersonType();
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return PersonType
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
     * @return PersonType
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
     * @return PersonType
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
     * @return PersonType
     */
    public function setSort($sort) {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return PersonType
     */
    public function setActive(bool $active): PersonType {
        $this->active = $active;
        return $this;
    }

}
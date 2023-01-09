<?php


namespace esas\cmsgate\bitrix\dto\sale;


class User
{
    private $id;
    private $name;
    private $secondName;
    private $lastName;
    private $email;
    private $personalPhone;
    private $personalCountry;
    private $personalState;
    private $personalCity;
    private $personalStreet;
    private $workPhone;
    private $workCountry;
    private $workState;
    private $workCity;
    private $workStreet;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
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
     * @return User
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecondName() {
        return $this->secondName;
    }

    /**
     * @param mixed $secondName
     * @return User
     */
    public function setSecondName($secondName) {
        $this->secondName = $secondName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return User
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersonalPhone() {
        return $this->personalPhone;
    }

    /**
     * @param mixed $personalPhone
     * @return User
     */
    public function setPersonalPhone($personalPhone) {
        $this->personalPhone = $personalPhone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersonalCountry() {
        return $this->personalCountry;
    }

    /**
     * @param mixed $personalCountry
     * @return User
     */
    public function setPersonalCountry($personalCountry) {
        $this->personalCountry = $personalCountry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersonalState() {
        return $this->personalState;
    }

    /**
     * @param mixed $personalState
     * @return User
     */
    public function setPersonalState($personalState) {
        $this->personalState = $personalState;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersonalCity() {
        return $this->personalCity;
    }

    /**
     * @param mixed $personalCity
     * @return User
     */
    public function setPersonalCity($personalCity) {
        $this->personalCity = $personalCity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersonalStreet() {
        return $this->personalStreet;
    }

    /**
     * @param mixed $personalStreet
     * @return User
     */
    public function setPersonalStreet($personalStreet) {
        $this->personalStreet = $personalStreet;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkPhone() {
        return $this->workPhone;
    }

    /**
     * @param mixed $workPhone
     * @return User
     */
    public function setWorkPhone($workPhone) {
        $this->workPhone = $workPhone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkCountry() {
        return $this->workCountry;
    }

    /**
     * @param mixed $workCountry
     * @return User
     */
    public function setWorkCountry($workCountry) {
        $this->workCountry = $workCountry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkState() {
        return $this->workState;
    }

    /**
     * @param mixed $workState
     * @return User
     */
    public function setWorkState($workState) {
        $this->workState = $workState;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkCity() {
        return $this->workCity;
    }

    /**
     * @param mixed $workCity
     * @return User
     */
    public function setWorkCity($workCity) {
        $this->workCity = $workCity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkStreet() {
        return $this->workStreet;
    }

    /**
     * @param mixed $workStreet
     * @return User
     */
    public function setWorkStreet($workStreet) {
        $this->workStreet = $workStreet;
        return $this;
    }
}
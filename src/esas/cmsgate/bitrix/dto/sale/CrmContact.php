<?php


namespace esas\cmsgate\bitrix\dto\sale;


class CrmContact
{
    private $id;
    private $name;
    private $secondName;
    private $lastName;
    private $email;
    private $phone;
    private $addressCountry;
    private $addressRegion;
    private $addressProvince;
    private $addressCity;
    private $address;
    private $addressPostalCode;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return CrmContact
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
     * @return CrmContact
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
     * @return CrmContact
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
     * @return CrmContact
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
     * @return CrmContact
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return CrmContact
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressCountry() {
        return $this->addressCountry;
    }

    /**
     * @param mixed $addressCountry
     * @return CrmContact
     */
    public function setAddressCountry($addressCountry) {
        $this->addressCountry = $addressCountry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressRegion() {
        return $this->addressRegion;
    }

    /**
     * @param mixed $addressRegion
     * @return CrmContact
     */
    public function setAddressRegion($addressRegion) {
        $this->addressRegion = $addressRegion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressProvince() {
        return $this->addressProvince;
    }

    /**
     * @param mixed $addressProvince
     * @return CrmContact
     */
    public function setAddressProvince($addressProvince) {
        $this->addressProvince = $addressProvince;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressCity() {
        return $this->addressCity;
    }

    /**
     * @param mixed $addressCity
     * @return CrmContact
     */
    public function setAddressCity($addressCity) {
        $this->addressCity = $addressCity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return CrmContact
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressPostalCode() {
        return $this->addressPostalCode;
    }

    /**
     * @param mixed $addressPostalCode
     * @return CrmContact
     */
    public function setAddressPostalCode($addressPostalCode) {
        $this->addressPostalCode = $addressPostalCode;
        return $this;
    }


}
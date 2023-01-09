<?php


namespace esas\cmsgate\bitrix\dto\sale;


class UserConverter
{
    public static function fromArray($dataArray) {
        $user = new User();
        $user
            ->setId($dataArray['ID'])
            ->setName($dataArray['NAME'])
            ->setLastName($dataArray['LAST_NAME'])
            ->setSecondName($dataArray['SECOND_NAME'])
            ->setEmail($dataArray['EMAIL'])
            ->setPersonalCountry($dataArray['PERSONAL_COUNTRY'])
            ->setPersonalCity($dataArray['PERSONAL_CITY'])
            ->setPersonalState($dataArray['PERSONAL_STATE'])
            ->setPersonalStreet($dataArray['PERSONAL_STREET'])
            ->setWorkCountry($dataArray['WORK_COUNTRY'])
            ->setWorkCity($dataArray['WORK_CITY'])
            ->setWorkState($dataArray['WORK_STATE'])
            ->setWorkStreet($dataArray['WORK_STREET'])
            ;
        return $user;
    }

    /**
     * @param $user User
     * @return array
     */
    public static function toArray($user) {
        $fields = [
            'ID' => $user->getId(),
            'NAME' => $user->getName(),
            'LAST_NAME' => $user->getLastName(),
            'SECOND_NAME' => $user->getSecondName(),
            'EMAIL' => $user->getEmail(),
            'PERSONAL_COUNTRY' => $user->getPersonalCountry(),
            'PERSONAL_STATE' => $user->getPersonalState(),
            'PERSONAL_CITY' => $user->getPersonalCity(),
            'PERSONAL_STREET' => $user->getPersonalStreet(),
            'WORK_COUNTRY' => $user->getWorkCountry(),
            'WORK_STATE' => $user->getWorkState(),
            'WORK_CITY' => $user->getWorkCity(),
            'WORK_STREET' => $user->getWorkStreet(),
        ];
        return $fields;
    }
}
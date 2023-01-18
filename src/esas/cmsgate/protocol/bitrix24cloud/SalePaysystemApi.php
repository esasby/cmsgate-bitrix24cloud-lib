<?php


namespace esas\cmsgate\protocol\bitrix24cloud;

use esas\cmsgate\bitrix\dto\sale\Paysystem;
use esas\cmsgate\bitrix\dto\sale\PaysystemConverter;
use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\bitrix\dto\sale\PaysystemHandler;
use esas\cmsgate\bitrix\dto\sale\PaysystemHandlerConverter;
use esas\cmsgate\utils\CMSGateException;

class SalePaysystemApi extends Bitrix24Api
{
    /**
     * @param $paysystem Paysystem
     * @return boolean
     * @throws CMSGateException
     */
    public function add(&$paysystem) {
        $fields = $this->toInstallArray($paysystem);
        $result = $this->restClient->call('sale.paysystem.add', $fields);
        $paysystem->setId($result['result']);
        $this->logger->info("Paysystem[" . $paysystem->getActionFile() . '] was added with id ' . $paysystem->getId());
        return $result['result'];
    }

    /**
     * @param $paysystem Paysystem
     */
    private function toInstallArray($paysystem) {
        $fields = PaysystemConverter::toArray($paysystem);
        $fields['BX_REST_HANDLER'] = $fields['ACTION_FILE']; // WTF??
        $personType = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(false)->salePersonTypes()->getForCRMContcat();
        $fields['PERSON_TYPE_ID'] = $personType->getId();
        return $fields;
    }

    /**
     * @param $paysystem Paysystem
     * @return boolean
     * @throws CMSGateException
     */
    public function restoreOrUpdateOrAdd($paysystem) {
        $installedSystems = $this->list(
            [],
            ['ACTION_FILE' => $paysystem->getActionFile()]);
        foreach ($installedSystems as $installedSystem) { //must be only one, because of action_file uniq
            $this->update($installedSystem->getId(), $paysystem); //restore or update
            return true;
        }
        return $this->add($paysystem);
    }

    /**
     * @param $paysystem Paysystem
     * @return boolean
     * @throws CmsgateException
     */
    public function update($id, $paysystem) {
        $result = $this->restClient->call('sale.paysystem.update', [
            'id' => $id,
            'fields' => $this->toInstallArray($paysystem)]);
        $this->logger->info("Paysystem[" . $id . '] was updated');
        return $result['result'];
    }

    public function getById($id) {
        return $this->list('*', ['id' => $id])[0]; //todo check
    }

    public function getSettingsForPayment($paymentId, $psId) {
        $result = $this->restClient->call('sale.paysystem.settings.payment.get', [
            'payment_id' => $paymentId,
            'PAY_SYSTEM_ID' => $psId]);
        return $result['result'];
    }

    /**
     * @return Paysystem[]
     * @throws CmsgateException
     */
    public function list($select, $filter = null) {
        $result = $this->restClient->call('sale.paysystem.list', [
            'select' => $select,
            'filter' => $filter]);
        $paysystems = array();
        foreach ($result['result'] as $dataArray)
            $paysystems[] = PaysystemConverter::fromArray($dataArray);
        return $paysystems;
    }

    /**
     * @param PaysystemHandler $newHandler
     * @return boolean
     * @throws CMSGateException
     */
    public function handlerAdd($newHandler) {
        $result = $this->restClient->call('sale.paysystem.handler.add', PaysystemHandlerConverter::toArray($newHandler));
        $newHandler->setId($result['result']);
        $this->logger->info("Handler[" . $newHandler->getCode() . '] was added with id ' . $newHandler->getId());
        return $result['result'];
    }

    /**
     * @return PaysystemHandler[]
     * @throws CmsgateException
     */
    public function handlersList() {
        $result = $this->restClient->call('sale.paysystem.handler.list');
        $handlers = array();
        foreach ($result['result'] as $dataArray)
            $handlers[] = PaysystemHandlerConverter::fromArray($dataArray);
        return $handlers;
    }

    /**
     * @param $handlerId
     * @param $handler PaysystemHandler
     * @return boolean
     * @throws CMSGateException
     */
    public function handlerUpdate($handlerId, $handler) {
        $result = $this->restClient->call('sale.paysystem.handler.update', array(
            "id" => $handlerId,
            "fields" => PaysystemHandlerConverter::toArray($handler)
        ));
        $this->logger->info("Handler[" . $handlerId . '] was updated');
        return $result['result'];
    }

    /**
     * @param PaysystemHandler $newHandler
     * @return boolean
     * @throws CMSGateException
     */
    public function handlerAddOrUpdate($newHandler) {
        try {
            $result = $this->handlerAdd($newHandler);
        } catch (CMSGateException $e) {
            $list = $this->handlersList();
            foreach ($list as $existedHandler) {
                if ($existedHandler->getCode() == $newHandler->getCode()) {
                    $this->handlerUpdate($existedHandler->getId(), $newHandler);
                }
            }
        }
        return $result;
    }

    /**
     * @return boolean
     * @throws CmsgateException
     */
    public function handlerDelete($id) {
        $result = $this->restClient->call('sale.paysystem.handler.delete', array("id" => $id));
        return $result['result'];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 14:13
 */

namespace esas\cmsgate\controller;

use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\Registry;
use esas\cmsgate\wrappers\OrderWrapperBitrix24Cloud;
use Exception;
use Throwable;

class ControllerBitrix24CloudNotify extends ControllerBitrix24Cloud
{
    /**
     * @param OrderWrapperBitrix24Cloud $orderWrapper
     * @throws Throwable
     */
    public function process($orderWrapper)
    {
        try {
            $this->checkOrderWrapper($orderWrapper);

            $loggerMainString = "Order[" . $orderWrapper->getOrderNumberOrId() . "]: ";
            $this->logger->info($loggerMainString . "Controller started");
            CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(true)->saleOrder()->updateStatus(
                $orderWrapper->getOrderId(),
                Registry::getRegistry()->getConfigWrapper()->getOrderStatusPayed());
            CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(true)->salePayment()->update(
                $orderWrapper->getOrderId(),
                Registry::getRegistry()->getConfigWrapper()->getOrderStatusPayed(),
                $orderWrapper->getExtId()
            );
            $this->logger->info($loggerMainString . "Bitrix24Cloud was successfully notified...");
        } catch (Throwable $e) {
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
            throw $e;
        } catch (Exception $e) { // для совместимости с php 5
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
            throw $e;
        }
    }

}
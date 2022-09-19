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
            CmsConnectorBitrix24Cloud::getInstance()->getBitrix24Api(true)->saleOrder()->updateStatus(
                $orderWrapper->getOrderId(),
                Registry::getRegistry()->getConfigWrapper()->getOrderStatusPayed());

            $notifyTildaRq = new TildaNotifyRq();
            $notifyTildaRq->setOrderId($orderWrapper->getOrderId());
            $notifyTildaRq->setAmount($orderWrapper->getAmount());
            $notifyTildaRq->setCurrency($orderWrapper->getCurrency());
            $protocol = new ProtocolTilda(Registry::getRegistry()->getCmsConnector()->getNotificationURL());
            $resp = $protocol->notifyOnOrderPayed($notifyTildaRq);
            if ($resp->hasError()) {
                $this->logger->error($loggerMainString . "Can not notify Tilda CMS...");
                throw new Exception($resp->getResponseMessage(), $resp->getResponseCode());
            } else {
                $this->logger->info($loggerMainString . "Tilda CMS was successfully notified...");
            }
            return $resp;
        } catch (Throwable $e) {
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
            throw $e;
        } catch (Exception $e) { // для совместимости с php 5
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
            throw $e;
        }
    }

}
<?php


namespace esas\cmsgate\bitrix24cloud;


use esas\cmsgate\bitrix\CmsgatePaysystem;
use esas\cmsgate\CmsConnectorBitrix;
use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\ConfigFields;
use esas\cmsgate\bridge\ShopConfigBitrix24;
use esas\cmsgate\BridgeConnectorBitrix24;
use esas\cmsgate\protocol\RequestParamsBitrix24Cloud;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\view\admin\ConfigFormBitrix24Cloud;

class InstallHelperBitrix24Cloud
{
    /**
     * @throws CMSGateException
     */
    public function install() {
        $this->checkAuth();
        $this->saveAuth();
        $this->addHandler();
        // $this->addPaysystem();
    }

    public function checkAuth() {
        $result = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(false)->salePaysystem()->list('id');
        if ($result['error'] = 0) {
            throw new CMSGateException("Auth data not correct");
        }
    }

    public function saveAuth() {
        $authData = new ShopConfigBitrix24();
        $authData
            ->setMemberId($_REQUEST[RequestParamsBitrix24Cloud::MEMBER_ID])
            ->setDomain($_REQUEST[RequestParamsBitrix24Cloud::DOMAIN])
            ->setAccessToken($_REQUEST[RequestParamsBitrix24Cloud::AUTH_ID])
            ->setExpireAt($_REQUEST[RequestParamsBitrix24Cloud::AUTH_EXPIRES])
            ->setRefreshToken($_REQUEST[RequestParamsBitrix24Cloud::REFRESH_ID]);
        BridgeConnectorBitrix24::fromRegistry()->getShopConfigRepository()->save($authData);
    }

    public function addHandler()
    {
        /** @var ConfigFormBitrix24Cloud $configFormBitrix */
        $configFormBitrix = Registry::getRegistry()->getConfigForm();

        $fields = [
            'NAME' => Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFields::paymentMethodName()),
            'CODE' => CmsConnectorBitrix::getInstance()->getModuleActionName(),
            'SORT' => '100',
            'SETTINGS' => [
                'FORM_DATA' => [
                    'ACTION_URI' => BridgeConnectorBitrix24::fromRegistry()->getHandlerActionUrl(),
                    'METHOD' => 'POST',
                    'FIELDS' => [
                        RequestParamsBitrix24Cloud::PAYMENT_ID => [
                            'CODE' => 'PAYMENT_ID', //используем payment_id, а не order_id, т.к. проще определить платежную систему
                            'VISIBLE' => 'N'
                        ],
                        RequestParamsBitrix24Cloud::ORDER_ID => [
                            'CODE' => 'ORDER_ID',
                            'VISIBLE' => 'N'
                        ]
                    ]
                ],
                'CODES' => array_merge(
                    $configFormBitrix->generateCodes(), [
                    'PAYMENT_ID' => [
                        'NAME' => 'Номер оплаты',
                        'SORT' => 400,
                        'GROUP' => 'PAYMENT',
                        'DEFAULT' => [
                            'PROVIDER_KEY' => 'PAYMENT',
                            'PROVIDER_VALUE' => 'ID']],
                    'ORDER_ID' => [
                        'NAME' => 'Номер заказа',
                        'SORT' => 400,
                        'GROUP' => 'ORDER',
                        'DEFAULT' => [
                            'PROVIDER_KEY' => 'ORDER',
                            'PROVIDER_VALUE' => 'ID']],])
            ]];
        return CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api()->salePaysystem()->handlerAdd($fields); //todo check if already present
    }

    /**
     * @param CmsgatePaysystem $paySystem
     * @return bool
     * @throws \esas\cmsgate\utils\CMSGateException
     */
    public function addPaysystem(&$paySystem)
    {
        $paySystemSettings = array(
            "NAME" => $paySystem->getName(),
            "DESCRIPTION" => $paySystem->getDescription(),
            "ACTION_FILE" => $paySystem->getActionFile(),
            "ACTIVE" => $paySystem->isActive() ? "Y" : "N",
            "ENTITY_REGISTRY_TYPE" => $paySystem->getType(), // без этого созданная платежная система не отображается в списке
//            "HAVE_RESULT_RECEIVE" => "Y",
//            "ENCODING" => "utf-8", на системах с windows-1251 при установке из marketplace это приводит к двойной конвертации итоговой страницы и некорректоному отображению
            "SORT" => $paySystem->getSort(),
        );

        if ($paySystem->getLogoPath() != '' && file_exists($paySystem->getLogoPath())) {
            $content = file_get_contents($paySystem->getLogoPath());
            $paySystemSettings['LOGOTYPE'] = base64_decode($content);
        }

        $previousVersionPSIds = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api()->salePaysystem()->list(
            ['ID'],
            ['ACTION_FILE' => $paySystem->getActionFile(),
                'ENTITY_REGISTRY_TYPE' => 'DELETED']); //hope only one

        if (!empty($previousVersionPSIds) && sizeof($previousVersionPSIds) > 0 && $previousVersionPSIds[0]["ID"] > 0)
            $result = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api()->salePaysystem()->update($previousVersionPSIds[0]["ID"], $paySystemSettings);
        else
            $result = CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api()->salePaysystem()->add($paySystemSettings);

        if ($result) {
            $paySystem->setId($result->getId()); //todo fix
        }
    }
}
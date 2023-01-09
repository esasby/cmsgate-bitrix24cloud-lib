<?php


namespace esas\cmsgate\bitrix;


use esas\cmsgate\bitrix\dto\sale\Paysystem;
use esas\cmsgate\CmsConnectorBitrix24Cloud;
use esas\cmsgate\ConfigFields;
use esas\cmsgate\bridge\ShopConfigBitrix24;
use esas\cmsgate\BridgeConnectorBitrix24;
use esas\cmsgate\protocol\RequestParamsBitrix24Cloud;
use esas\cmsgate\bitrix\dto\sale\PaysystemHandler;
use esas\cmsgate\bitrix\dto\sale\PaysystemHandlerSettings;
use esas\cmsgate\bitrix\dto\sale\PaysystemHandlerSettingsConfigField;
use esas\cmsgate\bitrix\dto\sale\PaysystemHandlerSettingsFormData;
use esas\cmsgate\bitrix\dto\sale\PaysystemHandlerSettingsFormDataField;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\view\admin\ConfigFormBitrix24Cloud;

class InstallHelperBitrix24Cloud
{
    /**
     * @throws CMSGateException
     */
    public function preinstall() {
        $this->checkAuth();
        $this->saveAuth();
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
            ->setMemberId(RequestParamsBitrix24Cloud::getMemberId())
            ->setDomain(RequestParamsBitrix24Cloud::getDomain())
            ->setAccessToken(RequestParamsBitrix24Cloud::getAccessToken())
            ->setExpireAt(RequestParamsBitrix24Cloud::getExpires())
            ->setRefreshToken(RequestParamsBitrix24Cloud::getRefreshToken());
        BridgeConnectorBitrix24::fromRegistry()->getShopConfigService()->saveConfig($authData);
    }

    public function addHandler() {
        /** @var ConfigFormBitrix24Cloud $configFormBitrix */
        $configFormBitrix = Registry::getRegistry()->getConfigForm();
        $newHandler = PaysystemHandler::newInstance()
            ->setName(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFields::paymentMethodName()))
            ->setCode(CmsConnectorBitrix24Cloud::fromRegistry()->getModuleActionName())
            ->setSort('100')
            ->setSettings(PaysystemHandlerSettings::newInstance()
                ->setFormData(PaysystemHandlerSettingsFormData::newInstance()
                    ->setActionUrl(BridgeConnectorBitrix24::fromRegistry()->getHandlerActionUrl())
                    ->setMethod('POST')
                    ->addField(PaysystemHandlerSettingsFormDataField::newInstance()
                        ->setRequestFieldKey(RequestParamsBitrix24Cloud::PAYMENT_ID)
                        ->setConfigFieldKey('PAYMENT_ID')
                        ->setVisible(false))
                    ->addField(PaysystemHandlerSettingsFormDataField::newInstance()
                        ->setRequestFieldKey(RequestParamsBitrix24Cloud::AMOUNT)
                        ->setConfigFieldKey('AMOUNT')
                        ->setVisible(false))
                    ->addField(PaysystemHandlerSettingsFormDataField::newInstance()
                        ->setRequestFieldKey(RequestParamsBitrix24Cloud::SHOP_ID)
                        ->setConfigFieldKey('MEMBER_ID')
                        ->setVisible(false))
//                    ->addField(PaysystemHandlerSettingsFormDataField::newInstance()
//                        ->setRequestFieldKey(RequestParamsBitrix24Cloud::SANDBOX)
//                        ->setConfigFieldKey(ConfigFields::sandbox())
//                        ->setVisible(false))
                    ->addField(PaysystemHandlerSettingsFormDataField::newInstance()
                        ->setRequestFieldKey(RequestParamsBitrix24Cloud::ORDER_ID)
                        ->setConfigFieldKey('ORDER_ID')
                        ->setVisible(false)))
                ->setConfigFields($configFormBitrix->generate())
                ->addConfigField(PaysystemHandlerSettingsConfigField::newInstance()
                    ->setKey('MEMBER_ID')
                    ->setName('Идентификатор магазина')
                    ->setGroup('PAYMENT')
                    ->setDefaultProviderKey('VALUE')
                    ->setDefaultProviderValue(RequestParamsBitrix24Cloud::getMemberId()))
                ->addConfigField(PaysystemHandlerSettingsConfigField::newInstance()
                    ->setKey('PAYMENT_ID')
                    ->setName('Номер оплаты')
                    ->setGroup('PAYMENT')
                    ->setDefaultProviderKey('PAYMENT')
                    ->setDefaultProviderValue('ID'))
                ->addConfigField(PaysystemHandlerSettingsConfigField::newInstance()
                    ->setKey('AMOUNT')
                    ->setName('Сумма')
                    ->setGroup('PAYMENT')
                    ->setDefaultProviderKey('PAYMENT')
                    ->setDefaultProviderValue('SUM'))
                ->addConfigField(PaysystemHandlerSettingsConfigField::newInstance()
                    ->setKey('ORDER_ID')
                    ->setName('Номер заказа')
                    ->setGroup('ORDER')
                    ->setDefaultProviderKey('ORDER')
                    ->setDefaultProviderValue('ID')));
        CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(false)->salePaysystem()->handlerAddOrUpdate($newHandler);
        return $newHandler;
    }

    /**
     * @param $handler PaysystemHandler
     * @return bool
     * @throws CMSGateException
     */
    public function addPaysystem($handlerCode, $logoPath) {
        $mainPaySystem = new Paysystem();
        $mainPaySystem
            ->setName(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFields::paymentMethodName()))
            ->setDescription(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFields::paymentMethodDetails()))
            ->setActionFile($handlerCode)
            ->setType('ORDER')
            ->setMain(true) // основная ПС модуля, ее ID будет храниться в OPTION_PAYSYSTEM_ID
            ->setLogoPath($logoPath)
            ->setSort(100);

        return CmsConnectorBitrix24Cloud::fromRegistry()->getBitrix24Api(false)->salePaysystem()->restoreOrUpdateOrAdd($mainPaySystem);
    }
}
<?php
namespace esas\cmsgate\wrappers;

use esas\cmsgate\bitrix24cloud\entity\Bitrix24SaleBasketItem;
use Throwable;

class OrderProductWrapperBitrix24Cloud extends OrderProductSafeWrapper
{
    /**
     * @var string[]
     */
    private $basketItem;

    /**
     * OrderProductWrapperTilda constructor.
     * @param array
     */
    public function __construct($orderItem)
    {
        parent::__construct();
        $this->basketItem = $orderItem;
    }

    /**
     * Артикул товара
     * @throws Throwable
     * @return string
     */
    public function getInvIdUnsafe()
    {
        return $this->basketItem[Bitrix24SaleBasketItem::PRODUCT_ID];
    }

    /**
     * Название или краткое описание товара
     * @throws Throwable
     * @return string
     */
    public function getNameUnsafe()
    {
        return $this->basketItem[Bitrix24SaleBasketItem::NAME];
    }

    /**
     * Количество товароа в корзине
     * @throws Throwable
     * @return mixed
     */
    public function getCountUnsafe()
    {
        return $this->basketItem[Bitrix24SaleBasketItem::QUANTITY];
    }

    /**
     * Цена за единицу товара
     * @throws Throwable
     * @return mixed
     */
    public function getUnitPriceUnsafe()
    {
        return $this->basketItem[Bitrix24SaleBasketItem::PRICE];
    }
}
<?php
namespace esas\cmsgate\wrappers;

use esas\cmsgate\protocol\Bitrix24SaleBasketItem;
use esas\cmsgate\bitrix\dto\sale\OrderItem;
use Throwable;

class OrderProductWrapperBitrix24Cloud extends OrderProductSafeWrapper
{
    /**
     * @var OrderItem
     */
    private $orderItem;

    /**
     * OrderProductWrapperTilda constructor.
     * @param array
     */
    public function __construct($orderItem)
    {
        parent::__construct();
        $this->orderItem = $orderItem;
    }

    /**
     * Артикул товара
     * @throws Throwable
     * @return string
     */
    public function getInvIdUnsafe()
    {
        return $this->orderItem->getProductId();
    }

    /**
     * Название или краткое описание товара
     * @throws Throwable
     * @return string
     */
    public function getNameUnsafe()
    {
        return $this->orderItem->getName();
    }

    /**
     * Количество товароа в корзине
     * @throws Throwable
     * @return mixed
     */
    public function getCountUnsafe()
    {
        return intval($this->orderItem->getQuantity());
    }

    /**
     * Цена за единицу товара
     * @throws Throwable
     * @return mixed
     */
    public function getUnitPriceUnsafe()
    {
        return $this->orderItem->getUnitPrice();
    }
}
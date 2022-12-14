<?php


namespace esas\cmsgate\bridge;


abstract class ShopConfigBitrix24Repository
{
    /**
     * @param $shopConfigBitrix24 ShopConfigBitrix24
     */
    public abstract function save($shopConfigBitrix24);

    /**
     * @param $memberId
     * @return ShopConfigBitrix24
     */
    public abstract function findByMemberId($memberId);
}
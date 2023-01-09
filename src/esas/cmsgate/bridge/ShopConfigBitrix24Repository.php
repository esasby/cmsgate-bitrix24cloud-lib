<?php


namespace esas\cmsgate\bridge;


abstract class ShopConfigBitrix24Repository extends ShopConfigRepository
{
    /**
     * @param $memberId
     * @return ShopConfigBitrix24
     */
    public abstract function findByMemberId($memberId);
}
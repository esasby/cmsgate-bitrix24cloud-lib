<?php


namespace esas\cmsgate\protocol\bitrix24cloud;

use esas\cmsgate\protocol\Bitrix24RestClient;

abstract class Bitrix24Api
{
    const ITEMS_PER_PAGE_LIMIT = 50;

    /**
     * @var Bitrix24RestClient
     */
    public $restClient = null;

    /**
     * @param $client Bitrix24RestClient
     */
    public function __construct(Bitrix24RestClient $client)
    {
        $this->restClient = $client;
    }
}
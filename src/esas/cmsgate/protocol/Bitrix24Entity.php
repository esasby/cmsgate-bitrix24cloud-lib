<?php


namespace esas\cmsgate\bitrix24cloud\entity;



use esas\cmsgate\protocol\Bitrix24RestClient;

abstract class Bitrix24Entity
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
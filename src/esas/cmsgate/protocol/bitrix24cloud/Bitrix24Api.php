<?php


namespace esas\cmsgate\protocol\bitrix24cloud;

use esas\cmsgate\protocol\Bitrix24RestClient;
use esas\cmsgate\utils\Logger;

abstract class Bitrix24Api
{
    const ITEMS_PER_PAGE_LIMIT = 50;

    /**
     * @var Bitrix24RestClient
     */
    protected $restClient = null;
    protected $logger;

    /**
     * @param $client Bitrix24RestClient
     */
    public function __construct(Bitrix24RestClient $client)
    {
        $this->logger = Logger::getLogger(get_class($this));
        $this->restClient = $client;
    }
}
<?php


namespace esas\cmsgate;


interface BridgeConfigBitrix24Cloud
{
    public function getAppId();

    public function getAppSecret();

    public function isDebugMode();
}
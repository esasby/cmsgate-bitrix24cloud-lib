<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 10.08.2018
 * Time: 12:21
 */

namespace esas\cmsgate;


class ConfigFieldsBitrix24Cloud extends ConfigFields
{
    public static function returnUrlSuccess() {
        return self::getCmsRelatedKey("return_url_success");
    }

    public static function returnUrlFailed() {
        return self::getCmsRelatedKey("return_url_failed");
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 27.09.2018
 * Time: 13:09
 */

namespace esas\cmsgate\lang;

class LocaleLoaderBitrix24Cloud extends LocaleLoaderCms
{
    public function getLocale()
    {
        return "ru";
//        return $_REQUEST['LANG']; //todo lang is present only in direct calls from bitrix, but not in callback
    }
}
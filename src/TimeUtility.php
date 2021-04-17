<?php

namespace Es3\Utility;

class TimeUtility
{
    /**
     * 获取当前日期和时间。
     * @param string $format
     * @return false|string
     */
    public static function getNowDateTime(string $format = 'Y-m-d H:i:s')
    {
        return date($format, time());
    }
}


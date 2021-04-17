<?php

namespace Es3\Utility;

class Md5Utility
{
    /**
     * 两次Md5.
     * @param string $string
     * @return string
     */
    public static function toMd5(string $string)
    {
        return md5(md5($string));
    }
}

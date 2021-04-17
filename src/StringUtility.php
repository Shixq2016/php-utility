<?php

namespace Es3\Utility;

class StringUtility
{
    /**
     * 下划线转驼峰
     * @param string $str
     * @param string $separator
     * @return string|string[]|null
     */
    public static function convertUnderline(string $str,string $separator = '_')
    {
        $str = preg_replace_callback("/([-{$separator}]+([a-z]{1}))/i",function($matches){
            return strtoupper($matches[2]);
        },$str);
        return $str;
    }

    /**
     * 驼峰转下划线
     * @param string $str
     * @param string $separator
     * @return string
     */
    public static function humpToLine(string $str,string $separator = '_'){
        $str = preg_replace_callback('/([A-Z]{1})/',function($matches) use($separator){
            return $separator.strtolower($matches[0]);
        },$str);
        return ltrim($str, $separator);
    }
}
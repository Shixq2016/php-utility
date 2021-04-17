<?php

namespace Es3\Utility;

class PhoneUtility
{
    /**
     * 隐藏手机号码的中间区号
     * @param string|null $mobile
     * @param string|null $replaceStr
     * @return string
     */
    public static function hiddenMobileArea(?string $mobile, ?string $replaceStr = '****'): string
    {
        if (empty($mobile)) {
            return '';
        }

        return substr_replace($mobile, $replaceStr,3,4);
    }
}
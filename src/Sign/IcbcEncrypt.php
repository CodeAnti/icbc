<?php

namespace CodeAnti\ICBC\Sign;

use CodeAnti\ICBC\Constant\IcbcConstant;
use Exception;

class IcbcEncrypt
{
    /**
     * encrypt content
     * @param $content
     * @param $encryptType
     * @param $encryptKey
     * @param $charset
     * @return string
     * @throws Exception
     */
    public static function encryptContent($content, $encryptType, $encryptKey, $charset)
    {
        if (IcbcConstant::$ENCRYPT_TYPE_AES == $encryptType) {
            return AES::AesEncrypt($content, base64_decode($encryptKey));
        } else {
            throw new Exception("Only support AES encrypt!");
        }
    }

    /**
     * decrypt content
     * @param $encryptedContent
     * @param $encryptType
     * @param $encryptKey
     * @param $charset
     * @return string
     * @throws Exception
     */
    public static function decryptContent($encryptedContent, $encryptType, $encryptKey, $charset)
    {
        if (IcbcConstant::$ENCRYPT_TYPE_AES == $encryptType) {
            return AES::AesDecrypt($encryptedContent, base64_decode($encryptKey));
        } else {
            throw new Exception("Only support AES decrypt!");
        }
    }
}

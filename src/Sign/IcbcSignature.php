<?php

namespace CodeAnti\ICBC\Sign;

use CodeAnti\ICBC\Constant\IcbcConstant;
use Exception;

class IcbcSignature
{
    /**
     * sign
     * @param $strToSign
     * @param $signType
     * @param $privateKey
     * @param $charset
     * @param $password
     * @return mixed|string
     * @throws Exception
     */
    public static function sign($strToSign, $signType, $privateKey, $charset, $password)
    {
        if (IcbcConstant::$SIGN_TYPE_CA == $signType) {
            return Ca::sign($strToSign, $privateKey, $password);
        } elseif (IcbcConstant::$SIGN_TYPE_RSA == $signType) {
            return RSA::sign($strToSign, $privateKey, IcbcConstant::$SIGN_SHA1RSA_ALGORITHMS);
        } elseif (IcbcConstant::$SIGN_TYPE_RSA2 == $signType) {
            return RSA::sign($strToSign, $privateKey, IcbcConstant::$SIGN_SHA256RSA_ALGORITHMS);
        } else {
            throw new Exception("Only support CA\RSA signature!");
        }
    }

    /**
     * verify
     * @param $strToSign
     * @param $signType
     * @param $publicKey
     * @param $charset
     * @param $signedStr
     * @param $password
     * @return int
     * @throws Exception
     */
    public static function verify($strToSign, $signType, $publicKey, $charset, $signedStr, $password)
    {
        if (IcbcConstant::$SIGN_TYPE_CA == $signType) {
            return Ca::verify($strToSign, $publicKey, $password);
        } elseif (IcbcConstant::$SIGN_TYPE_RSA == $signType) {
            return RSA::verify($strToSign, $signedStr, $publicKey, IcbcConstant::$SIGN_SHA1RSA_ALGORITHMS);
        } elseif (IcbcConstant::$SIGN_TYPE_RSA2 == $signType) {
            return RSA::verify($strToSign, $signedStr, $publicKey, IcbcConstant::$SIGN_SHA256RSA_ALGORITHMS);
        } else {
            throw new Exception("Only support CA or RSA signature verify!");
        }
    }
}

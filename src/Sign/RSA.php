<?php

namespace CodeAnti\ICBC\Sign;

use CodeAnti\ICBC\Constant\IcbcConstant;
use Exception;

class RSA
{
    /**
     * sign
     * @param $content
     * @param $privateKey
     * @param $algorithm
     * @return string
     * @throws Exception
     */
    public static function sign($content, $privateKey, $algorithm)
    {
        if (IcbcConstant::$SIGN_SHA1RSA_ALGORITHMS == $algorithm) {
            openssl_sign($content, $signature, "-----BEGIN PRIVATE KEY-----\n" . $privateKey . "\n-----END PRIVATE KEY-----", OPENSSL_ALGO_SHA1);
        } elseif (IcbcConstant::$SIGN_SHA256RSA_ALGORITHMS == $algorithm) {
            openssl_sign($content, $signature, "-----BEGIN PRIVATE KEY-----\n" . $privateKey . "\n-----END PRIVATE KEY-----", OPENSSL_ALGO_SHA256);
        } else {
            throw new Exception("Only support OPENSSL_ALGO_SHA1 or OPENSSL_ALGO_SHA256 algorithm signature!");
        }
        return base64_encode($signature);
    }

    /**
     * verify
     * @param $content
     * @param $signature
     * @param $publicKey
     * @param $algorithm
     * @return int
     * @throws Exception
     */
    public static function verify($content, $signature, $publicKey, $algorithm)
    {
        if (IcbcConstant::$SIGN_SHA1RSA_ALGORITHMS == $algorithm) {
            return openssl_verify($content, base64_decode($signature), "-----BEGIN PUBLIC KEY-----\n" . $publicKey . "\n-----END PUBLIC KEY-----", OPENSSL_ALGO_SHA1);
        } elseif (IcbcConstant::$SIGN_SHA256RSA_ALGORITHMS == $algorithm) {
            return openssl_verify($content, base64_decode($signature), "-----BEGIN PUBLIC KEY-----\n" . $publicKey . "\n-----END PUBLIC KEY-----", OPENSSL_ALGO_SHA256);
        } else {
            throw new Exception("Only support OPENSSL_ALGO_SHA1 or OPENSSL_ALGO_SHA256 algorithm signature verify!");
        }
    }
}

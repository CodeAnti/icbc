<?php

namespace CodeAnti\ICBC;

use Exception;

class IcbcCa
{
    /**
     * sign
     * @param $content
     * @param $privatekey
     * @param $password
     * @return mixed
     * @throws Exception
     */
    public static function sign($content, $privatekey, $password)
    {
        if (!extension_loaded('infosec')) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                dl('php_infosec.dll');
            } else {
                dl('infosec.so');
            }
        }

        $plaint = $content;
        if (strlen($plaint) <= 0) {
            throw new Exception("no source data input");
        }

        $contents = base64_decode($privatekey);
        $key = substr($contents, 2);

        $pass = $password;
        if (strlen($pass) <= 0) {
            throw new Exception("no key password input");
        } else {
            $signature = sign($plaint, $key, $pass);
            $code = current($signature);
            $len = next($signature);
            $signcode = base64enc($code);
            return current($signcode);
        }
    }

    /**
     * verify
     * @param $content
     * @param $publicKey
     * @param $password
     */
    public static function verify($content, $publicKey, $password)
    {
        return 1;
    }
}

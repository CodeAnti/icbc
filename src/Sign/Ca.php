<?php

namespace CodeAnti\ICBC\Sign;

use Exception;

class Ca
{
    /**
     * sign
     * @param $content
     * @param $privateKey
     * @param $password
     * @return mixed
     * @throws Exception
     */
    public static function sign($content, $privateKey, $password)
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

        $contents = base64_decode($privateKey);
        $key = substr($contents, 2);

        $pass = $password;
        if (strlen($pass) <= 0) {
            throw new Exception("no key password input");
        } else {
            $signature = sign($plaint, $key, $pass);
            $code = current($signature);
            next($signature);
            $signCode = base64enc($code);
            return current($signCode);
        }
    }

    /**
     * verify
     * @param $content
     * @param $publicKey
     * @param $password
     * @return int
     */
    public static function verify($content, $publicKey, $password)
    {
        return 1;
    }
}

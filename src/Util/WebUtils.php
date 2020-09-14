<?php

namespace CodeAnti\ICBC\Util;

use CodeAnti\ICBC\Constant\IcbcConstant;
use Exception;

class WebUtils
{
    private static $version = "v2_20170324";

    /**
     * get
     * @param $url
     * @param $params
     * @param $charset
     * @return bool|string
     * @throws Exception
     */
    public static function doGet($url, $params, $charset)
    {
        $headers = array();
        $headers[IcbcConstant::$VERSION_HEADER_NAME] = self::$version;
        $getUrl = self::buildGetUrl($url, $params, $charset);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 8000);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 30000);


        $response = curl_exec($ch);
        $resInfo = curl_getinfo($ch);
        curl_close($ch);

        if ($resInfo["http_code"] != 200) {
            throw new Exception("response status code is not valid. status code: " . $resInfo["http_code"]);
        }

        return $response;
    }

    /**
     * post
     * @param $url
     * @param $params
     * @param $charset
     * @return bool|string
     * @throws Exception
     */
    public static function doPost($url, $params, $charset)
    {
        $headers = array();
        $headers[] = 'Expect:';
        $headers[IcbcConstant::$VERSION_HEADER_NAME] = self::$version;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 8000);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 30000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


        $response = curl_exec($ch);
        $resInfo = curl_getinfo($ch);
        curl_close($ch);

        if ($resInfo["http_code"] != 200) {
            throw new Exception("response status code is not valid. status code: " . $resInfo["http_code"]);
        }
        return $response;
    }

    /**
     * build get url
     * @param $strUrl
     * @param $params
     * @param $charset
     * @return string
     */
    public static function buildGetUrl($strUrl, $params, $charset)
    {
        if ($params == null || count($params) == 0) {
            return $strUrl;
        }
        $buildUrlParams = http_build_query($params);
        if (strrpos($strUrl, '?', 0) != (strlen($strUrl) + 1)) { //最后是否以？结尾
            return $strUrl . '?' . $buildUrlParams;
        }
        return $strUrl . $buildUrlParams;
    }

    /**
     * build order sign str
     * @param $path
     * @param $params
     * @return string
     */
    public static function buildOrderedSignStr($path, $params)
    {
        ksort($params);
        $comSignStr = $path . '?';

        $hasParam = false;
        foreach ($params as $key => $value) {
            if (null == $key || "" == $key || null == $value || "" == $value) {

            } else {
                if ($hasParam) {
                    $comSignStr = $comSignStr . '&';
                } else {
                    $hasParam = true;
                }
                $comSignStr = $comSignStr . $key . '=' . $value;
            }
        }
        return $comSignStr;
    }

    /**
     * build form
     * @param $url
     * @param $params
     * @return string
     */
    public static function buildForm($url, $params)
    {
        $buildFields = self::buildHiddenFields($params);
        return '<form name="auto_submit_form" method="post" action="' . $url . '">' . "\n" . $buildFields . '<input type="submit" value="立刻提交" style="display:none" >' . "\n" . '</form>' . "\n" . '<script>document.forms[0].submit();</script>';
    }

    /**
     * build hidden fields
     * @param $params
     * @return string
     */
    public static function buildHiddenFields($params)
    {
        if ($params == null || count($params) == 0) {
            return '';
        }

        $result = '';
        foreach ($params as $key => $value) {
            if ($key == null || $value == null) {
                continue;
            }
            $buildField = self::buildHiddenField($key, $value);
            $result = $result . $buildField;
        }
        return $result;
    }

    /**
     * build hidden field
     * @param $key
     * @param $value
     * @return string
     */
    public static function buildHiddenField($key, $value)
    {
        return '<input type="hidden" name="' . $key . '" value="' . preg_replace('/"/', '&quot;', $value) . '">' . "\n";
    }
}

<?php

namespace CodeAnti\ICBC\Client;

use Carbon\Carbon;
use CodeAnti\ICBC\Constant\IcbcConstant;
use CodeAnti\ICBC\Sign\IcbcEncrypt;
use CodeAnti\ICBC\Sign\IcbcSignature;
use CodeAnti\ICBC\Util\WebUtils;
use Exception;

class DefaultIcbcClient
{
    /**
     * @var $appId
     */
    public $appId;

    /**
     * @var $privateKey
     */
    public $privateKey;

    /**
     * @var $signType
     */
    public $signType;

    /**
     * @var $charset
     */
    public $charset;

    /**
     * @var $format
     */
    public $format;

    /**
     * @var $icbcPublicKey
     */
    public $icbcPublicKey;

    /**
     * @var $encryptKey
     */
    public $encryptKey;

    /**
     * @var $encryptType
     */
    public $encryptType;

    /**
     * @var string|string[]|null $ca
     */
    public $ca;

    /**
     * @var $password
     */
    public $password;

    /**
     * DefaultIcbcClient constructor.
     * @param $appId
     * @param $privateKey
     * @param $signType
     * @param $charset
     * @param $format
     * @param $icbcPublicKey
     * @param $encryptKey
     * @param $encryptType
     * @param $ca
     * @param $password
     */
    public function __construct($appId, $privateKey, $signType, $charset, $format, $icbcPublicKey, $encryptKey, $encryptType, $ca, $password)
    {
        $this->appId = $appId;
        $this->privateKey = $privateKey;
        if ($signType == null || $signType == "") {
            $this->signType = IcbcConstant::$SIGN_TYPE_RSA;
        } else {
            $this->signType = $signType;
        }

        if ($charset == null || $charset == "") {
            $this->charset = IcbcConstant::$CHARSET_UTF8;
        } else {
            $this->charset = $charset;
        }

        if ($format == null || $format == "") {
            $this->format = IcbcConstant::$FORMAT_JSON;
        } else {
            $this->format = $format;
        }

        $this->icbcPublicKey = $icbcPublicKey;
        $this->encryptKey = $encryptKey;
        $this->encryptType = $encryptType;
        $this->password = $password;

        // 去除签名数据及证书数据中的空格
        if ($ca != null && $ca != "") {
            $ca = preg_replace("/\s*|\t/", "", $ca);
        }
        $this->ca = $ca;
    }

    /**
     * execute request
     * @param $request
     * @param $msgId
     * @param $appAuthToken
     * @return false|string
     * @throws Exception
     */
    function execute($request, $msgId, $appAuthToken)
    {
        $params = $this->prepareParams($request, $msgId, $appAuthToken);

        //发送请求 接收响应
        if ($request["method"] == "GET") {
            $respStr = WebUtils::doGet($request["serviceUrl"], $params, $this->charset);
        } elseif ($request["method"] == "POST") {
            $respStr = WebUtils::doPost($request["serviceUrl"], $params, $this->charset);
        } else {
            throw new Exception("Only support GET or POST http method!");
        }

        // 增加了对传回报文中含有中文字符以及反斜杠的转换(json_encode(str,JSON_UNESCAPED_UNICODE(240)+JSON_UNESCAPED_SLASHES(80)=320))
        $respBizContentStr = json_encode(json_decode($respStr, true)[IcbcConstant::$RESPONSE_BIZ_CONTENT], 320);
        $sign = json_decode($respStr, true)[IcbcConstant::$SIGN];

        // 解析响应
        $passed = IcbcSignature::verify($respBizContentStr, IcbcConstant::$SIGN_TYPE_RSA, $this->icbcPublicKey, $this->charset, $sign, $this->password);

        if (!$passed) {
            throw new Exception("icbc sign verify not passed!");
        }

        if ($request["isNeedEncrypt"]) {
            $respBizContentStr = IcbcEncrypt::decryptContent(substr($respBizContentStr, 1, strlen($respBizContentStr) - 2), $this->encryptType, $this->encryptKey, $this->charset);
        }
        // 返回解析结果
        return $respBizContentStr;
    }

    /**
     * prepare params
     * @param $request
     * @param $msgId
     * @param $appAuthToken
     * @return array
     * @throws Exception
     */
    function prepareParams($request, $msgId, $appAuthToken)
    {
        $bizContentStr = json_encode($request["biz_content"]);
        $path = parse_url($request["serviceUrl"], PHP_URL_PATH);
        $params = array();

        if ($request["extraParams"] != null) {
            $params = array_merge($params, $request["extraParams"]);
        }

        $params[IcbcConstant::$APP_ID] = $this->appId;
        $params[IcbcConstant::$SIGN_TYPE] = $this->signType;
        $params[IcbcConstant::$CHARSET] = $this->charset;
        $params[IcbcConstant::$FORMAT] = $this->format;
        $params[IcbcConstant::$CA] = $this->ca;
        $params[IcbcConstant::$APP_AUTH_TOKEN] = $appAuthToken;
        $params[IcbcConstant::$MSG_ID] = $msgId;
        $params[IcbcConstant::$TIMESTAMP] = Carbon::now()->format("Y-m-d H:i:s");

        if ($request["isNeedEncrypt"]) {
            if ($bizContentStr != null) {
                $params[IcbcConstant::$ENCRYPT_TYPE] = $this->encryptType;
                $params[IcbcConstant::$BIZ_CONTENT_KEY] = IcbcEncrypt::encryptContent($bizContentStr, $this->encryptType, $this->encryptKey, $this->charset);
            }
        } else {
            $params[IcbcConstant::$BIZ_CONTENT_KEY] = $bizContentStr;
        }

        $strToSign = WebUtils::buildOrderedSignStr($path, $params);
        $signedStr = IcbcSignature::sign($strToSign, $this->signType, $this->privateKey, $this->charset, $this->password);
        $params[IcbcConstant::$SIGN] = $signedStr;
        return $params;

    }

    /**
     * json
     * @param $array
     * @return false|string
     */
    function jsonTranslate($array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = urlencode($value);
        }
        return json_encode($array);
    }

    /**
     * encode
     * @param $array
     * @return mixed
     */
    function encodeOperations($array)
    {
        foreach ((array)$array as $key => $value) {
            if (is_array($value)) {
                $this->encodeOperations($array[$key]);
            } else {
                $array[$key] = urlencode(mb_convert_encoding($value, 'UTF-8', 'GBK'));
            }
        }
        return $array;
    }
}

<?php

namespace CodeAnti\ICBC\Client;

use CodeAnti\ICBC\Constant\IcbcConstant;
use CodeAnti\ICBC\Util\WebUtils;
use Exception;

class UilIcbcClient extends DefaultIcbcClient
{
    /**
     * UilIcbcClient constructor.
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
    function __construct($appId, $privateKey, $signType, $charset, $format, $icbcPublicKey, $encryptKey, $encryptType, $ca, $password)
    {
        parent::__construct($appId, $privateKey, $signType, $charset, $format, $icbcPublicKey, $encryptKey, $encryptType, $ca, $password);
    }

    /**
     * @param $request
     * @param $msgId
     * @param $appAuthToken
     * @return string
     * @throws Exception
     */
    function buildPostForm($request, $msgId, $appAuthToken)
    {
        $params = $this->prepareParams($request, $msgId, null);
        $urlQueryParams = $this->buildUrlQueryParams($params);
        $url = WebUtils::buildGetUrl($request["serviceUrl"], $urlQueryParams, $this->charset);
        return WebUtils::buildForm($url, $this->buildBodyParams($params));
    }

    /**
     * @param $params
     * @return array
     */
    function buildUrlQueryParams($params)
    {
        $apiParamNames[] = IcbcConstant::$SIGN;
        $apiParamNames[] = IcbcConstant::$APP_ID;
        $apiParamNames[] = IcbcConstant::$SIGN_TYPE;
        $apiParamNames[] = IcbcConstant::$CHARSET;
        $apiParamNames[] = IcbcConstant::$FORMAT;
        $apiParamNames[] = IcbcConstant::$ENCRYPT_TYPE;
        $apiParamNames[] = IcbcConstant::$TIMESTAMP;
        $apiParamNames[] = IcbcConstant::$MSG_ID;

        $urlQueryParams = [];
        foreach ($params as $key => $value) {
            if (in_array($key, $apiParamNames)) {
                $urlQueryParams[$key] = $value;
            }
        }
        return $urlQueryParams;
    }

    /**
     * @param $params
     * @return array
     */
    function buildBodyParams($params)
    {
        $apiParamNames[] = IcbcConstant::$SIGN;
        $apiParamNames[] = IcbcConstant::$APP_ID;
        $apiParamNames[] = IcbcConstant::$SIGN_TYPE;
        $apiParamNames[] = IcbcConstant::$CHARSET;
        $apiParamNames[] = IcbcConstant::$FORMAT;
        $apiParamNames[] = IcbcConstant::$ENCRYPT_TYPE;
        $apiParamNames[] = IcbcConstant::$TIMESTAMP;
        $apiParamNames[] = IcbcConstant::$MSG_ID;

        $urlQueryParams = [];
        foreach ($params as $key => $value) {
            if (in_array($key, $apiParamNames)) {
                continue;
            }
            $urlQueryParams[$key] = $value;
        }
        return $urlQueryParams;
    }
}

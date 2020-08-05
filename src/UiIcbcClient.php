<?php

namespace CodeAnti\ICBC;

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
        $apiParamNames[] = IcbcConstants::$SIGN;
        $apiParamNames[] = IcbcConstants::$APP_ID;
        $apiParamNames[] = IcbcConstants::$SIGN_TYPE;
        $apiParamNames[] = IcbcConstants::$CHARSET;
        $apiParamNames[] = IcbcConstants::$FORMAT;
        $apiParamNames[] = IcbcConstants::$ENCRYPT_TYPE;
        $apiParamNames[] = IcbcConstants::$TIMESTAMP;
        $apiParamNames[] = IcbcConstants::$MSG_ID;

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
        $apiParamNames[] = IcbcConstants::$SIGN;
        $apiParamNames[] = IcbcConstants::$APP_ID;
        $apiParamNames[] = IcbcConstants::$SIGN_TYPE;
        $apiParamNames[] = IcbcConstants::$CHARSET;
        $apiParamNames[] = IcbcConstants::$FORMAT;
        $apiParamNames[] = IcbcConstants::$ENCRYPT_TYPE;
        $apiParamNames[] = IcbcConstants::$TIMESTAMP;
        $apiParamNames[] = IcbcConstants::$MSG_ID;

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

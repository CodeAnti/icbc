<?php
namespace CodeAnti\ICBC;

use CodeAnti\ICBC\Client\DefaultIcbcClient;
use Exception;

class IcbcPay
{
    // 工银e企付支付申请服务
    const ICBC_APPLY_PAY_API = "/api/mybank/pay/cpay/cppayapply/V2";

    // 工银e企付确认支付服务
    const ICBC_PRESERVATION_PAY_API = "/api/mybank/pay/cpay/cppreservationpay/V2";

    // 工银e企付取消支付服务
    const ICBC_CANCEL_PRESERVATION_PAY_API = "/api/mybank/pay/cpay/cppreservationcancel/V2";

    // 工银e企付支付申请查询服务
    const ICBC_ORDER_QUERY_API = "/api/mybank/pay/cpay/cporderquery/V2";

    // 工银e企付支付申请关闭服务
    const ICBC_ORDER_CLOSE_API = "/api/mybank/pay/cpay/cporderclose/V1";

    // 工银e企付追缴保留金额服务
    const ICBC_AMOUNT_DEPOSIT_API = "/api/mybank/pay/cpay/cpamountdeposit/V1";

    public $serviceUrl;
    public $appId;
    public $privateKey;
    public $signType;
    public $charset;
    public $format;
    public $apiGatewayPublicKey;
    public $encryptKey;
    public $encryptType;
    public $ca;
    public $password;

    public $defaultIcbcClient;

    /**
     * IcbcPay constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->serviceUrl = $config['service_url'];
        $this->appId = $config['app_id'];
        $this->privateKey = $config['private_key'];
        $this->signType = $config['sign_type'];
        $this->charset = $config['charset'];
        $this->format = $config['format'];
        $this->apiGatewayPublicKey = $config['api_gateway_public_key'];
        $this->encryptKey = $config['encrypt_key'];
        $this->encryptType= $config['encrypt_type'];
        $this->ca = $config['ca'];
        $this->password = $config['password'];

        $this->defaultIcbcClient = new DefaultIcbcClient(
            $this->appId,
            $this->privateKey,
            $this->signType,
            $this->charset,
            $this->format,
            $this->apiGatewayPublicKey,
            $this->encryptKey,
            $this->encryptType,
            $this->ca,
            $this->password
        );
    }

    /**
     * 工银e企付支付申请服务
     * @param string $msgId
     * @param array $bizContent
     * @param array|null $extraParams
     * @return mixed
     * @throws Exception
     */
    public function applyPay(string $msgId, array $bizContent, array $extraParams = null)
    {
        $response = $this->defaultIcbcClient->execute([
            "serviceUrl" => $this->serviceUrl . self::ICBC_APPLY_PAY_API,
            "method" => 'POST',
            "isNeedEncrypt" => false,
            "extraParams" => $extraParams,
            "biz_content" => $bizContent
        ], $msgId, '');

        return json_decode($response, true);
    }

    /**
     * 工银e企付确认支付服务
     * @param string $msgId
     * @param array $bizContent
     * @param array|null $extraParams
     * @return mixed
     * @throws Exception
     */
    public function preservationPay(string $msgId, array $bizContent, array $extraParams = null)
    {
        $response = $this->defaultIcbcClient->execute([
            "serviceUrl" => $this->serviceUrl . self::ICBC_PRESERVATION_PAY_API,
            "method" => 'POST',
            "isNeedEncrypt" => false,
            "extraParams" => $extraParams,
            "biz_content" => $bizContent
        ], $msgId, '');

        return json_decode($response, true);
    }

    /**
     * 工银e企付取消支付服务
     * @param string $msgId
     * @param array $bizContent
     * @param array|null $extraParams
     * @return mixed
     * @throws Exception
     */
    public function preservationCancel(string $msgId, array $bizContent, array $extraParams = null)
    {
        $response = $this->defaultIcbcClient->execute([
            "serviceUrl" => $this->serviceUrl . self::ICBC_CANCEL_PRESERVATION_PAY_API,
            "method" => 'POST',
            "isNeedEncrypt" => false,
            "extraParams" => $extraParams,
            "biz_content" => $bizContent
        ], $msgId, '');

        return json_decode($response, true);
    }

    /**
     * 工银e企付支付申请查询服务
     * @param string $msgId
     * @param array $bizContent
     * @param array|null $extraParams
     * @return mixed
     * @throws Exception
     */
    public function orderQuery(string $msgId, array $bizContent, array $extraParams = null)
    {
        $response = $this->defaultIcbcClient->execute([
            "serviceUrl" => $this->serviceUrl . self::ICBC_ORDER_QUERY_API,
            "method" => 'POST',
            "isNeedEncrypt" => false,
            "extraParams" => $extraParams,
            "biz_content" => $bizContent
        ], $msgId, '');

        return json_decode($response, true);
    }

    /**
     * 工银e企付支付申请关闭服务
     * @param string $msgId
     * @param array $bizContent
     * @param array|null $extraParams
     * @return mixed
     * @throws Exception
     */
    public function orderClose(string $msgId, array $bizContent, array $extraParams = null)
    {
        $response = $this->defaultIcbcClient->execute([
            "serviceUrl" => $this->serviceUrl . self::ICBC_ORDER_CLOSE_API,
            "method" => 'POST',
            "isNeedEncrypt" => false,
            "extraParams" => $extraParams,
            "biz_content" => $bizContent
        ], $msgId, '');

        return json_decode($response, true);
    }

    /**
     * 工银e企付追缴保留金额服务
     * @param string $msgId
     * @param array $bizContent
     * @param array|null $extraParams
     * @return mixed
     * @throws Exception
     */
    public function amountDeposit(string $msgId, array $bizContent, array $extraParams = null)
    {
        $response = $this->defaultIcbcClient->execute([
            "serviceUrl" => $this->serviceUrl . self::ICBC_AMOUNT_DEPOSIT_API,
            "method" => 'POST',
            "isNeedEncrypt" => false,
            "extraParams" => $extraParams,
            "biz_content" => $bizContent
        ], $msgId, '');

        return json_decode($response, true);
    }
}
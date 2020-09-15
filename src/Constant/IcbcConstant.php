<?php

namespace CodeAnti\ICBC\Constant;

class IcbcConstant
{
    public static $SIGN_TYPE = "sign_type";

    public static $SIGN_TYPE_RSA = "RSA";

    public static $SIGN_TYPE_RSA2 = "RSA2";

    public static $SIGN_TYPE_SM2 = "SM2";

    public static $SIGN_TYPE_CA = "CA";

    public static $SIGN_SHA1RSA_ALGORITHMS = "SHA1WithRSA";

    public static $SIGN_SHA256RSA_ALGORITHMS = "SHA256WithRSA";

    public static $ENCRYPT_TYPE_AES = "AES";

    public static $APP_ID = "app_id";

    public static $FORMAT = "format";

    public static $TIMESTAMP = "timestamp";

    public static $SIGN = "sign";

    public static $APP_AUTH_TOKEN = "app_auth_token";

    public static $CHARSET = "charset";

    public static $NOTIFY_URL = "notify_url";

    public static $RETURN_URL = "return_url";

    public static $ENCRYPT_TYPE = "encrypt_type";

    public static $BIZ_CONTENT_KEY = "biz_content";

    /**
     * 默认时间格式
     */
    public static $DATE_TIME_FORMAT = "Y-m-d H:i:s";

    /**
     * Date默认时区
     */
    public static $DATE_TIMEZONE = "Etc/GMT+8";

    /**
     * Date上海时区
     */
    public static $DATA_TIMEZONE_SHANGHAI = "";

    /**
     * UTF-8字符集
     */
    public static $CHARSET_UTF8 = "UTF-8";

    /**
     * GBK字符集
     */
    public static $CHARSET_GBK = "GBK";

    /**
     * JSON 应格式
     */
    public static $FORMAT_JSON = "json";

    /**
     * XML 应格式
     */
    public static $FORMAT_XML = "xml";

    public static $CA = "ca";

    public static $PASSWORD = "password";

    public static $RESPONSE_BIZ_CONTENT = "response_biz_content";

    /**
     * 消息唯一编号
     */
    public static $MSG_ID = "msg_id";

    /**
     * sdk版本号在header中的key
     */
    public static $VERSION_HEADER_NAME = "APIGW-VERSION";

    /** 渠道类型
     * 1-PC端
     * 2-移动端
     */
    public static $PAY_CHANNEL_PC = '1';
    public static $PAY_CHANNEL_MOBILE = '2';

    /**
     * 境内外标志
     * 1-境内
     * 2-境外
     */
    public static $INTERNATIONAL_FLAG_INSIDE = '1';
    public static $INTERNATIONAL_FLAG_OUTSIDE = '2';

    /**
     * 支付方式
     * 1-直接支付：资金直接支付给收款方
     * 2-保留支付：资金保留在付款方或者收款方账户，后续需要调用方主动调起指令划拨或解保留。境内外币只支持保留支付，
     * 3-担保支付
     */
    public static $PAY_MODE_DIRECT = '1';
    public static $PAY_MODE_PRESERVATION = '2';
    public static $PAY_MODE_GUARANTEE = '3';

    /**
     * 保留方向 保留支付时上送
     * 1-付方保留，
     * 2-收方保留(收方保留时，收款账号仅支持工行往来户)，境内外币只支持付方保留
     */
    public static $RESERVE_DIRECT_PAYER = '1';
    public static $RESERVE_DIRECT_RECEIVER = '2';

    /**
     * 担保支付时上送
     * 301-担保
     */
    public static $OPERATION_TYPE_GUARANTEE = '301';

    /**
     * 是否异步支付（0-否，1-是）
     * 异步支付：适用于采购与财务分离的场景，采购人员仅下单，由财务人员登录工行企业网银进行订单支付；
     * 选择异步支付时，付款人账号必送。
     * 境内外币、境外不支持异步支付。
     */
    public static $FLAG_SYNC = '0';
    public static $FLAG_ASYNC = '1';

    /**
     * 境内支持合法币种，境外时,详见14币种表，暂不支持科威特第纳尔币种。
     * 担保支付，仅支持001-人民币
     */
    public static $ORDER_CURR_CHINA = '001';

    /**
     * 认证模式
     * 1-免认证
     * 0或空-其他
     * 安心账户退款时必须上送1
     */
    public static $IDENTITY_MODE_EXTRA = "0";
    public static $IDENTITY_MODE_CERTIFICATION_FREE = "1";
}

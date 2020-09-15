<?php
namespace CodeAnti\ICBC\Util;

class GenerateCodeUtils
{
    /**
     * 交易流水号
     * @param String $prefix
     * @return string
     */
    public static function generatePartnerSeq(String $prefix = '')
    {
        return $prefix . 'PTS' . rand(10000, 99999) . time();
    }

    /**
     * 订单编号
     * @param String $prefix
     * @return string
     */
    public static function generateOrderCode(String $prefix = '')
    {
        return $prefix . 'ODC' . rand(10000, 99999) . time();
    }

    /**
     * 生成msgId
     * @param String $prefix
     * @return string
     */
    public static function generateMsgId(String $prefix = '')
    {
        return $prefix . 'MSG' . rand(10000, 999999) . time();
    }
}
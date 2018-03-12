<?php

namespace libs\Pay;

/**
 * 支付通用函数
 *
 * @author chenqionghe
 * @package libs\Pay
 */
class LPayTool
{
    /**
     * 从支付订单号中获取orderSn
     *
     * @param string $tradeNumber 支付唯一流水号
     * @return bool|string
     */
    public static function getOrderSnByTradeNumber($tradeNumber)
    {
        $pos = strpos($tradeNumber, '-');
        if ($pos !== false) {
            return substr($tradeNumber, 0, $pos);
        }
        return $tradeNumber;
    }

    /**
     * 根据订单号生成支付唯一流水号 格式为: orderSn - time()
     *
     * @param $orderSn
     * @return string
     */
    public static function createTradeNumberByOrderSn($orderSn)
    {
        return $orderSn . '-' . time();
    }
}
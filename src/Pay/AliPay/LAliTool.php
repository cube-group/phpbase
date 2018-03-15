<?php

namespace libs\Pay\AliPay;

use Exception;
use libs\Utils\Arrays;
use libs\Validate\LValidator;

/**
 * 支付宝工具
 *
 * @author chenqionghe
 * @package libs\Pay\AliPay
 */
class LAliTool
{
    /** @var bool 引入SDK */
    static $initSdk = false;

    /**
     * LAliPay constructor.
     * @throws Exception
     */
    public static function initSdk()
    {
        if (!self::$initSdk) {
            require __DIR__ . "/alipay-sdk-PHP-20170615110533/AopSdk.php";
            self::$initSdk = true;
        }
    }


    /**
     * 获取交易状态对应中文
     *
     * @param $status
     * @return mixed|null
     */
    public static function getTradeStatusCn($status)
    {
        $map = [
            'WAIT_BUYER_PAY' => '交易创建，等待买家付款',
            'TRADE_CLOSED' => '未付款交易超时关闭，或支付完成后全额退款',
            'TRADE_SUCCESS' => '交易支付成功',
            'TRADE_FINISHED' => '交易结束，不可退款',
        ];
        return Arrays::get($map, $status, '无对应状态值!');
    }

}

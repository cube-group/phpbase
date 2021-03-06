<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/6/14
 * Time: 下午4:23
 */

namespace libs\Pay\WeChat;

use libs\Curl\LCurl;
use libs\Pay\LPayConfig;
use libs\Utils\ServerUtil;
use libs\Utils\Strings;
use libs\Utils\XMLUtil;
use libs\Validate\LValidator;

/**
 * Class LWechatPayQrcode.
 * 微信支付(扫码支付通道)
 * @package libs\Pay\WebChat
 */
class LWechatPayQrcode extends LWechatPay
{
    protected function getTradeType()
    {
        return LPayConfig::WECHAT_TRADE_NATIVE; // TODO: Change the autogenerated stub
    }

    protected function unifiedOrder($data)
    {
        $result = parent::unifiedOrder($data);
        if ($result) {
            return isset($result['code_url']) ? $result['code_url'] : false;
        }
        return false;
    }
}
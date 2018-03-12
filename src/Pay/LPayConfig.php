<?php

namespace libs\Pay;

use Exception;
use libs\Pay\AliPay\LAliPayApp;
use libs\Pay\AliPay\LAliPayCallback;
use libs\Pay\WeChat\LWechatPayApp;
use libs\Pay\WeChat\LWechatPayCallback;
use libs\Pay\WeChat\LWechatPayQrcode;
use libs\Pay\YeePay\LYeePayCallback;
use libs\Pay\YeePay\LYeePayOneKey;
use libs\Service\LSConfig;

/**
 * 支付相关配置
 *
 * @author chenqionghe
 * @package libs\Pay
 */
class LPayConfig
{
    /**
     * 微信支付,扫码支付
     */
    const TYPE_WECHAT_QRCODE = LWechatPayQrcode::class;
    /**
     * 微信支付,APP支付
     */
    const TYPE_WECHAT_APP = LWechatPayApp::class;
    /**
     * 支付宝,APP支付
     */
    const TYPE_ALIPAY_APP = LAliPayApp::class;

    /**
     * 易宝支付,一键支付
     */
    const TYPE_YEEPAY_ONEKEY = LYeePayOneKey::class;

    /**
     * 易宝支付回调
     */
    const CALLBACK_YEEPAY = LYeePayCallback::class;

    /**
     * 微信支付回调
     */
    const CALLBACK_WECHAT = LWechatPayCallback::class;
    /**
     * 支付宝支付回调
     */
    const CALLBACK_ALI = LAliPayCallback::class;


    /**
     * 微信支付,统一下单地址.
     */
    const URL_WECHAT_UNIFIED_ORDER = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    /**
     * 微信支付,二维码支付模式.
     */
    const WECHAT_TRADE_NATIVE = 'NATIVE';
    /**
     * 微信支付,公众号支付模式.
     */
    const WECHAT_TRADE_JSAPI = 'JSAPI';
    /**
     * 微信支付,APP支付模式.
     */
    const WECHAT_TRADE_APP = 'APP';


    /**
     * 根据支付类型返回支付配置
     *
     * @param $type
     * @return array|null
     * @throws Exception
     */
    public static function getPayConfigByType($type)
    {
        //微信-扫码支付
        if (in_array($type, [
            self::TYPE_WECHAT_QRCODE,
        ])) {
            return LSConfig::get()->pay->wechatPublic->toArray();
        }

        //微信-App支付
        if (in_array($type, [
            self::TYPE_WECHAT_APP,
            self::CALLBACK_WECHAT,
        ])) {
            return LSConfig::get()->pay->wechatOpen->toArray();
        }

        //支付宝
        if (in_array($type, [
            self::TYPE_ALIPAY_APP,
            self::CALLBACK_ALI,
        ])) {
            return LSConfig::get()->pay->alipay->toArray();
        }

        //易宝
        if (in_array($type, [
            self::TYPE_YEEPAY_ONEKEY,
            self::CALLBACK_YEEPAY,
        ])) {
            return LSConfig::get()->pay->yeepay->toArray();
        }

        throw new Exception("invalid type: {$type} ");
    }
}
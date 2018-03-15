<?php

use libs\Pay\ILPayReturn;
use libs\Pay\LPayConfig;
use libs\Pay\LPay;

require __DIR__ . '/../src/autoload.php';

/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/6/6
 * Time: 下午4:44
 */
class TestLPay
{

    public $orderSn = '01234567890';
    public $price = 0.01;
    public $body = "测试数据";
    public $notifyUrl = 'http://www.baidu.com';


    public function __construct()
    {
        define('APP_MODE', 'local');

        date_default_timezone_set('Asia/Shanghai');

    }

    /**
     * 微信支付扫码支付
     *
     * @throws Exception
     */
    public function wechatQrcodePay()
    {
        $obj = LPay::create(LPayConfig::TYPE_WECHAT_QRCODE, []);
        $data = $obj->run([
            'price' => $this->price,
            'orderSn' => $this->orderSn,
            'body' => $this->body,
            'notifyUrl' => $this->notifyUrl
        ]);
        dump($data);
    }

    /**
     * 微信支付APP支付
     *
     * @throws Exception
     */
    public function wechatAppPay()
    {
        $obj = LPay::create(LPayConfig::TYPE_WECHAT_APP, []);
        $data = $obj->run([
            'price' => $this->price,
            'orderSn' => $this->orderSn,
            'body' => $this->body,
            'notifyUrl' => $this->notifyUrl
        ]);
        dump($data);
    }

    /**
     * 模拟路由使用微信支付APP回调
     */
    public function wechatAppPayCallback()
    {
        $callback = LPay::callback(LPayConfig::CALLBACK_WECHAT,[]);
        $callback->returns(new MyWechatCallbackReturn());
    }


    /**
     * 支付宝APP支付
     */
    public function alipayAppPay()
    {
        $obj = LPay::create(LPayConfig::TYPE_ALIPAY_APP, []);
        $data = $obj->run([
            'price' => $this->price,
            'orderSn' => $this->orderSn,
            'body' => $this->body,
            'notifyUrl' => $this->notifyUrl
        ]);
        dump($data);
    }

    /**
     * 支付宝APP回调
     */
    public function alipayAppPayCallback()
    {
        $callback = LPay::callback(LPayConfig::CALLBACK_ALI, []);
        $result = $callback->returns(new MyAlipayCallbackReturn());
        dump($result);
    }


    /**
     * 易宝一键支付支付
     */
    public function yeepayOnekeyPay()
    {
        $obj = LPay::create(LPayConfig::TYPE_YEEPAY_ONEKEY, []);
        $data = $obj->run([
            'price' => $this->price,
            'orderSn' => $this->orderSn,
            'body' => $this->body,
            'notifyUrl' => $this->notifyUrl,
            'returnUrl' => $this->notifyUrl
        ]);
        dump($data);
    }


    /**
     * 易宝支付回调
     */
    public function yeepayCallback()
    {
        $callback = LPay::callback(LPayConfig::CALLBACK_YEEPAY, []);
        $result = $callback->returns(new MyYeepayCallbackReturn());
        dump($result);
    }

}

/**
 * Class MyWechatCallback
 * 项目中使用
 */
class MyWechatCallbackReturn implements ILPayReturn
{
    public function returns($originalResult, $result)
    {
        // TODO: $result['price'] 金额(单位:分)
        // TODO: $result['orderSn'] 单号
        // TODO: $result['transactionId'] 此次微信支付的唯一微信支付号
        // TODO: $result['tradeNumber'] 此次微信支付的唯一商户号
        // TODO: $result['time'] 正式支付的时间戳
        // TODO: $result['result'] bool是否支付成功
        // TODO: $result['bank'] 用户支付的银行卡编号
        // TODO: $result['orderSn']已经处理过SUCCESS了请不要重复录库操作
        // TODO: $result maybe null
        // TODO: start your logic with $result
        // TODO: db、i/o、curl and so on
    }
}

/**
 * Class MyWechatCallback
 * 项目中使用
 */
class MyAlipayCallbackReturn implements ILPayReturn
{
    public function returns($originalResult, $result)
    {
        //TODO
    }
}


/**
 * Class MyYeepayCallbackReturn
 */
class MyYeepayCallbackReturn implements ILPayReturn
{
    public function returns($originalResult, $result)
    {
        dump($originalResult);
        dump($result);
    }
}


$t = new TestLPay();
$t->wechatAppPay();
$t->wechatAppPayCallback();
$t->wechatQrcodePay();
$t->alipayAppPay();
$t->alipayAppPayCallback();
$t->yeepayOnekeyPay();
$t->yeepayCallback();

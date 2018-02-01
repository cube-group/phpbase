<?php

namespace libs\Pay\AliPay;

use AlipayTradeAppPayRequest;
use AopClient;
use libs\Pay\Error\LPayError;
use libs\Pay\LPayTool;
use libs\Utils\Arrays;
use libs\Validate\LValidator;


/**
 * 支付宝APP支付
 *
 * Class LAliPayApp
 * @package libs\Pay\AliPay
 */
class LAliPayApp extends LAliPay
{

    /**
     * @param array $data
     * @return mixed
     */
    public function run(array $data)
    {
        $val = new LValidator($data);
        $val->rules([
            ['required', ['body', 'orderSn', 'price', 'notifyUrl']],
        ]);
        if (!$val->validate()) {
            $this->lastError = LPayError::ERR_PARAMETERS;
            return false;
        }

        $aop = new AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = $this->config['appId'];
        $aop->rsaPrivateKey = $this->config['rsaPrivateKey'];
        $aop->format = $this->config['format'];
        $aop->charset = $this->config['charset'];
        $aop->signType = $this->config['signType'];
        $aop->alipayrsaPublicKey = $this->config['alipayrsaPublicKey'];

        $request = new AlipayTradeAppPayRequest();
        $bizcontent = json_encode([
            'body' => $data['body'],
            'subject' => $data['orderSn'],//商品的标题/交易标题/订单标题/订单关键字等。
            'out_trade_no' => LPayTool::createTradeNumberByOrderSn($data['orderSn']),//商户网站唯一订单号
            'total_amount' => $data['price'],//订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]
            'product_code' => 'QUICK_MSECURITY_PAY',//销售产品码，商家和支付宝签约的产品码，为固定值QUICK_MSECURITY_PAY
            'passback_params' => urldecode(json_encode([
                'orderSn' => Arrays::get($data, 'params', [])
            ], JSON_UNESCAPED_UNICODE)),//公用回传参数，如果请求时传递了该参数，则返回给商户时会回传该参数。支付宝会在异步通知时将该参数原样返回。本参数必须进行UrlEncode之后才可以发送给支付宝
        ], JSON_UNESCAPED_UNICODE);

        $request->setNotifyUrl($data['notifyUrl']);
        $request->setBizContent($bizcontent);
        $response = $aop->sdkExecute($request);
        return htmlspecialchars($response);
    }


}

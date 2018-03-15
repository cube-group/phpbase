<?php

namespace libs\Pay\YeePay;

use Exception;
use libs\Pay\Error\LPayError;
use libs\Pay\LPayTool;
use libs\Utils\Arrays;
use libs\Utils\ServerUtil;
use libs\Validate\LValidator;
use RequestService;

/**
 * 易宝支付-一键支付
 *
 * @author chenqionghe
 * @package libs\Pay\YeePay
 */
class LYeePayOneKey extends LYeePay
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

        $reqData = [
            'requestid' => LPayTool::createTradeNumberByOrderSn($data['orderSn']),//(必传)商户订单号
            'amount' => $data['price'],//(必传)商户订单金额, 单位元，.必须大于等于 0.01
            'assure' => Arrays::get($data, 'assure', '0'),//(可选)是否需要担保
            'productname' => $data['orderSn'],//(必填)商品标题,orderSn
            'productcat' => '',//(可选)商品类别
            'productdesc' => $data['body'],//(可选)商品描述
            'divideinfo' => '',//(可选)分账信息
            'callbackurl' => $data['notifyUrl'],//异步通知地址
            'webcallbackurl' => Arrays::get($data, 'returnUrl', ''),//同步回调地址
            'bankid' => '',//(可选)银行编号
            'period' => Arrays::get($data, 'period', ''),//(担保有效期)当 assure=1 时必填， 最大值：30
            'memo' => '',//(可选)商户备注
            'orderexpdate' => '',//(可选)订单有效期,单位：分钟 微信：5<= date <= 120 其他：5<=date<=1440
            'payproducttype' => 'ONEKEY',//移动收银台固定值
            'userno' => '',//(可选)仅适用于一键支付
            'cardname' => Arrays::get($data, 'cardname', ''),//(可选)持卡人姓名，如传送过来则会限 制用户只能用对应这个开户名的 银行卡支付
            'idcard' => Arrays::get($data, 'idcard', ''),//(可选)身份证号，如传送过来则会限制 用户只能用对应这个身份证号的 银行卡支付
            'bankcardnum' => Arrays::get($data, 'bankcardnum', ''),//(可选)银行卡号，如传送过来则会限制 用户只能用这张银行卡支付
            'mobilephone' => Arrays::get($data, 'mobilephone'),//(可选)预留手机号，如传送过来则会限 制用户只能用对应这个预留手机 号的银行卡支付
            'appid' => '',//(可选)需要展示报备的商户名称或推荐 关注公众号时,必传
            'openid' => '',//(可选)如传了 appid 则必传此项
            'directcode' => '',//商户直接指定本次支付需要使用 哪一种支付方式(如果不传,则默认 使用所有开通的支付方式)
            'ip' => ServerUtil::serverIp(),
        ];

        try {
            $req = new RequestService('pay');
            $req->sendRequest($reqData);
            $req->receviceResponse();
            $req->getRequest();
            $response = $req->getResponseData();
            return [
                'orderSn' => $data['orderSn'],//单号
                'price' => Arrays::get($response, 'amount'),//支付金额
                'tradeNumber' => Arrays::get($response, 'requestid'),//商户订单号
                'transactionId' => Arrays::get($response, 'externalid'),//易宝流水号
                'payurl' => Arrays::get($response, 'payurl'),//支付地址
            ];
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        }
    }


}
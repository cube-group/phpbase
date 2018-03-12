<?php

namespace libs\Pay\AliPay;

use AopClient;
use libs\Pay\LPayCallback;
use libs\Pay\LPayTool;
use libs\Utils\Arrays;

/**
 * @author chenqionghe
 *
 * @package libs\Pay\AliPay
 */
class LAliPayCallback extends LPayCallback
{
    /**
     * LAliPayCallback constructor.
     * @param null $config
     */
    public function __construct($config)
    {
        LAliTool::initSdk();
        parent::__construct($config);
    }

    /**
     * 成功返回
     *
     * @return string
     */
    protected function returnSuccess()
    {
        return 'success';
    }

    /**
     * 失败返回
     *
     * @return string
     */
    protected function returnFailed()
    {
        return 'fail';
    }


    /**
     * 验证回调合法性
     *
     * @return bool
     */
    protected function payResultAuth()
    {
        $aop = new AopClient();
        $aop->alipayrsaPublicKey = $this->config['alipayrsaPublicKey'];
        $payResultOriginal = $this->getPayResultOriginal();
        if (!Arrays::get($payResultOriginal, 'sign')) {
            return false;
        }
        return $aop->rsaCheckV1($payResultOriginal, NULL, $this->config['signType']);
    }


    /**
     * 处理支付宝POST数据
     *
     * @return mixed
     */
    final protected function payResultFunc()
    {
        $this->payResultOriginal = $_POST;
        //支付信息示例
        /*
        $aliData = [
            'notify_time' => '2015-14-27 15:45:58',//通知时间
            'notify_type' => 'trade_status_sync',//通知类型
            'notify_id' => 'ac05099524730693a8b330c5ecf72da9786',//通知校验ID
            'app_id' => '2014072300007148',//支付宝分配给开发者的应用Id
            'charset' => 'utf-8',//编码格式
            'version' => '1.0',//接口版本
            'sign_type' => 'RSA2',//签名类型
            'sign' => '601510b7970e52cc63db0f44997cf70e',//签名
            'trade_no' => '2013112011001004330000121536',//支付宝交易号
            'out_trade_no' => '6823789339978248',//商户订单号
            'out_biz_no' => 'HZRF001',//商户业务号
            'buyer_id' => '2088102122524333',//买家支付宝用户号
            'buyer_logon_id' => '15901825620',//买家支付宝账号
            'seller_id' => '2088101106499364',//卖家支付宝用户号
            'seller_email' => 'zhuzhanghu@alitest.com',//卖家支付宝账号
            'trade_status' => 'TRADE_SUCCESS',//交易状态
            'total_amount' => '20',//订单金额
            'receipt_amount' => '15',//实收金额
            'invoice_amount' => '10.00',//开票金额
            'buyer_pay_amount' => '13.88',//付款金额
            'point_amount' => '12.00',//集分宝金额
            'refund_fee' => '2.58',//总退款金额
            'subject' => '当面付交易',//订单标题
            'body' => '当面付交易内容',//商品描述
            'gmt_create' => '2015-04-27 15:45:57',//交易创建时间
            'gmt_payment' => '2015-04-27 15:45:57',//交易付款时间
            'gmt_refund' => '2015-04-28 15:45:57.320',//交易退款时间
            'gmt_close' => '2015-04-29 15:45:57',//交易结束时间
            'fund_bill_list' => '[{“amount”:“15.00”,“fundChannel”:“ALIPAYACCOUNT”}]',//支付金额信息
            'passback_params' => 'merchantBizType%3d3C%26merchantBizNo%3d2016010101111',//回传参数
            'voucher_detail_list' => '[{“amount”:“0.20”,“merchantContribute”:“0.00”,“name”:“一键创建券模板的券名称”,“otherContribute”:“0.20”,“type”:“ALIPAY_DISCOUNT_VOUCHER”,“memo”:“学生卡8折优惠”]',//优惠券信息
        ];
        */
        if (empty($this->payResultOriginal)) {
            return false;
        }
        $result['result'] = Arrays::get($this->payResultOriginal, 'trade_status') == 'TRADE_SUCCESS';
        $result['price'] = Arrays::get($this->payResultOriginal, 'total_amount', 0);
        $result['time'] = strtotime(Arrays::get($this->payResultOriginal, 'gmt_payment'));
        $result['tradeNumber'] = Arrays::get($this->payResultOriginal, 'out_trade_no', '');
        $result['transactionId'] = Arrays::get($this->payResultOriginal, 'trade_no', '');
        $result['bank'] = '';//
        $result['orderSn'] = LPayTool::getOrderSnByTradeNumber($result['tradeNumber']);
        return $result;
    }


}

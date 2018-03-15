<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/6/23
 * Time: 下午5:02
 */

namespace libs\Pay\YeePay;


use Exception;
use libs\Pay\LPayCallback;
use libs\Pay\LPayTool;
use libs\Utils\Arrays;
use libs\Validate\LValidator;

class LYeePayCallback extends LPayCallback
{
    /**
     * 支付解析后的结果
     * @var
     */
    private $payResultArray;


    /**
     * LYeePayCallback constructor.
     * @param null $config
     * @throws Exception
     */
    public function __construct($config)
    {
        $val = new LValidator($config);
        $val->rules([
            ['required', ['customernumber', 'keyValue']],
        ]);
        if (!$val->validate()) {
            throw new Exception(__CLASS__ . 'parameters error: ' . json_encode($val->errors(), JSON_UNESCAPED_UNICODE));
        }
        LYeepayTool::initSdk($config);
        parent::__construct($config);
    }

    /**
     * 成功返回
     *
     * @return string
     */
    protected function returnSuccess()
    {
        return 'SUCCESS';
    }

    /**
     * 失败返回
     *
     * @return string
     */
    protected function returnFailed()
    {
        return 'FAIL';
    }


    /**
     * 验证回调合法性
     *
     * @return bool
     */
    protected function payResultAuth()
    {
        $customernumber = getCustomerNumber();
        $keyForHmac = getKeyValue();
        $infConfig = LYeepayTool::getInfConfig();

        $bizConfig = $infConfig['pay'];

        if (isset($this->payResultArray["code"]) && "1" != $this->payResultArray["code"]) {
            $this->lastError = "response error, errmsg = [{$this->payResultArray["msg"]}], errcode = [{$this->payResultArray["code"]}].";
            return false;
        }
        if (array_key_exists("customError", $this->payResultArray) && "" != $this->payResultArray["customError"]) {
            $this->lastError = "response.customError error, errmsg = [{$this->payResultArray["customError"]}], errcode = [{$this->payResultArray["code"]}].";
            return false;
        }

        if (isset($this->payResultArray["customernumber"]) && $this->payResultArray["customernumber"] != $customernumber) {
            $this->lastError = "customernumber not equals, request is [" . $customernumber . "], response is [" . $this->payResultArray["customernumber"] . "].";
            return false;
        }

        //验证返回签名
        $hmacGenConfig = $bizConfig["needCallbackHmac"];
        $hmacData = array();
        foreach ($hmacGenConfig as $hKey => $hValue) {
            $v = "";
            //判断$queryData中是否存在此索引并且是否可访问
            if (isViaArray($this->payResultArray, $hValue) && $this->payResultArray[$hValue]) {
                $v = $this->payResultArray[$hValue];
            }
            //取得对应加密的明文的值
            $hmacData[$hKey] = $v;
        }
        $hmac = getHmac($hmacData, $keyForHmac);

        if (!isset($this->payResultArray['hmac'])) {
            $this->lastError = "hmac not found";
            return false;
        }

        if ($hmac != $this->payResultArray["hmac"]) {
            $this->lastError = "hmac not equals, response is [{$this->payResultArray["hmac"]}], gen is [{$hmac}].";
            return false;
        }

        if (isset($this->payResultArray["notifytype"]) && "SERVER" != $this->payResultArray["notifytype"]) {
            $this->lastError = "notifytype error, notifytype is [{$this->payResultArray["notifytype"] }]";
            return false;
        }
        return true;
    }


    /**
     * 处理支付宝POST数据
     *
     * @return mixed
     */
    final protected function payResultFunc()
    {
        //记录原始请求
        $this->payResultOriginal = $_REQUEST;

        $this->payResultArray = [];
        //解密数据
        if (isset($_REQUEST['data'])) {
            $responseData = getDeAes($_REQUEST['data'], getKeyForAes());
            $this->payResultArray = json_decode($responseData, true);
        }

        //记录解析出的原始数组
        //支付信息示例
        /*
        $yeepayData = [
            'customernumber' => '',//商户编号
            'requestid' => '',//商户订单号
            'code' => '', //成功返回：1，其他请参考附录：8.1 返回码列表
            'notifytype' => '', //通知类型 REDIRECT：重定向通知 SERVER ：服务器点对点通知
            'externalid' => '', //易宝交易流水号
            'amount' => '', //订单金额, 单位:元
            'cardno' => '', //卡号后四位
            'bankcode' => '', //银行编码
            'cardtype' => '', //银行卡类别
            'paydate' => '', //支付成功时间
            'payProduct' => '', //支付方式
            'hmac' => '', //签名信息
        ];
        */
        if (empty($this->payResultOriginal)) {
            return false;
        }
        $result['result'] = Arrays::get($this->payResultArray, 'code') == '1';
        $result['price'] = Arrays::get($this->payResultArray, 'amount', 0);
        $result['time'] = strtotime(Arrays::get($this->payResultArray, 'paydate'));
        $result['tradeNumber'] = Arrays::get($this->payResultArray, 'requestid', '');
        $result['transactionId'] = Arrays::get($this->payResultArray, 'externalid', '');
        $result['bank'] = Arrays::get($this->payResultArray, 'bankcode', '');
        $result['orderSn'] = LPayTool::getOrderSnByTradeNumber($result['tradeNumber']);
        return $result;
    }

}
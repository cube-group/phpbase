<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/6/17
 * Time: 上午10:53
 */

namespace libs\Pay;

/**
 * Class LPayCallback
 * 支付回调基类
 * @package libs\Pay
 */
abstract class LPayCallback
{
    /**
     * 相关支付的配置
     * @var array
     */
    protected $config;
    /**
     * [
     * 'price'=>'支付金额(单位:分),
     * 'orderSn'=>'单号',
     * 'time'=>'支付时间戳',
     * 'result'=>'支付结果bool',
     * 'bank'=>'付款银行'
     * ]
     * @var array
     */
    protected $payResult;
    /**
     * 支付原始结果
     * @var mixed
     */
    protected $payResultOriginal;


    /**
     * 最近一次错误
     *
     * @var
     */
    protected $lastError;

    /**
     * LPayCallback constructor.
     * @param null $config
     */
    public function __construct($config = null)
    {
        $this->config = $config;
        $this->payResult = $this->payResultFunc();
        if (!$this->payResultAuth()) {
            $this->payResult = false;
        }
    }

    /**
     * 验证回调合法性
     * @return bool
     */
    protected function payResultAuth()
    {
        // TODO: payResultAuth
        return false;
    }

    /**
     * 获取解析之后的支付回调数据
     * @return array|bool
     */
    protected function payResultFunc()
    {
        //todo...
        return [
            'price' => 0,//支付金额(单位:分)
            'orderSn' => '',//福佑单号
            'transactionId' => '',//支付方单号
            'time' => time(),//支付时间戳
            'result' => true,//支付结果
            'bank' => ''//支付的银行
        ];
    }

    /**
     * 成功返回
     * @return mixed
     */
    protected function returnSuccess()
    {
        //todo...
        return true;
    }

    /**
     * 失败返回
     * @return mixed
     */
    protected function returnFailed()
    {
        //todo...
        return true;
    }

    /**
     * 处理返回逻辑
     * @param $instance ILPayReturn
     * @return mixed
     */
    public function returns(ILPayReturn $instance)
    {
        $instance->returns($this->payResultOriginal, $this->payResult);

        if ($this->payResult && isset($this->payResult['result']) && $this->payResult['result'] == true) {
            return $this->returnSuccess();
        } else {
            return $this->returnFailed();
        }
    }

    /**
     * 返回支付的原始数据
     */
    public function getPayResultOriginal()
    {
        return $this->payResultOriginal;
    }
}
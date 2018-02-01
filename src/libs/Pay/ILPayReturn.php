<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/6/23
 * Time: 下午4:17
 */

namespace libs\Pay;


/**
 * Interface ILPayReturn
 * Callback传入实例接口
 * @package libs\Pay
 */
interface ILPayReturn
{
    /**
     * 回调结果获取
     *
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
     * @param string $originalResult 原始支付回调数据
     * @param bool|array $result 支付回调处理结果
     * @return mixed
     */
    public function returns($originalResult, $result);
}
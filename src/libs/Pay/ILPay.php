<?php
namespace libs\Pay;

/**
 * 统一处理逻辑接口(支付, 查询 ,退款)
 *
 * Interface ILPay
 * @author chenqionghe
 * @package libs\Pay
 */
interface ILPay
{

    /**
     * 处理逻辑
     *
     * @param array $data
     * @return mixed
     */
    public function run(array $data);


    /**
     * 返回最近一次的错误
     *
     * @return mixed
     */
    public function lastError();
}
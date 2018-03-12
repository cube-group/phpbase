<?php

namespace libs\Pay;

use Exception;

/**
 * 统一支付调用类
 *
 * Class LPay
 * @author chenqionghe
 * @package libs\Pay
 */
class LPay
{
    /**
     * @param $type string 类型
     * @param $config array 配置
     * @return ILPay
     * @throws Exception
     */
    public static function create($type, array $config)
    {
        if (!class_exists($type)) {
            throw new Exception("class {$type} not exist");
        }
        $instance = new $type($config);
        if ($instance instanceof ILPay) {
            return $instance;
        }
        throw new Exception("实例必须实现ILPay接口");
    }


    /**
     * @param $type string 类型
     * @return LPayCallback
     * @throws Exception
     */
    public static function callback($type, $config = [])
    {
        if (!class_exists($type)) {
            throw new Exception("class not exist");
        }
        $instance = new $type($config);
        if ($instance instanceof LPayCallback) {
            return $instance;
        }
        throw new Exception("实例必须继承LPayCallback");
    }
}
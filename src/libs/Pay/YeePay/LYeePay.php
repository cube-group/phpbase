<?php

namespace libs\Pay\YeePay;

use Exception;
use libs\Pay\Error\LPayError;
use libs\Pay\ILPay;
use libs\Validate\LValidator;

/**
 * 易宝支付基类
 * Class LYeePay
 * @author chenqionghe
 * @package libs\Pay\YeePay
 */
abstract class LYeePay implements ILPay
{
    protected $config;
    protected $lastError;

    /**
     * LYeePay constructor.
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $val = new LValidator($config);
        $val->rules([
            ['required', ['customernumber', 'keyValue']],
        ]);
        if (!$val->validate()) {
            $this->lastError = LPayError::ERR_PARAMETERS;
            throw new Exception(__CLASS__ . 'parameters error: ' . json_encode($val->errors(), JSON_UNESCAPED_UNICODE));
        }
        LYeepayTool::initSdk($config);
    }

    /**
     * @return string
     */
    public function lastError()
    {
        return $this->lastError;
    }
}
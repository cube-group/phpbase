<?php

namespace libs\Pay\AliPay;

use Exception;
use libs\Pay\Error\LPayError;
use libs\Pay\ILPay;
use libs\Validate\LValidator;

/**
 * 支付宝基类
 * Class LAliPay
 * @author chenqionghe
 * @package libs\Pay\AliPay
 */
abstract class LAliPay implements ILPay
{
    protected $config;
    protected $lastError;

    /**
     * LAliPay constructor.
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        LAliTool::initSdk();
        $this->config = $config;
        $val = new LValidator($config);
        $val->rules([
            ['required', ['appId', 'signType', 'rsaPrivateKey', 'alipayrsaPublicKey']],
        ]);
        if (!$val->validate()) {
            $this->lastError = LPayError::ERR_PARAMETERS;
            throw new Exception(__CLASS__ . 'parameters error: ' . json_encode($val->errors(), JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * @return string
     */
    public function lastError()
    {
        return $this->lastError;
    }

}

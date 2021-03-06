<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/6/15
 * Time: 下午2:55
 */

namespace libs\Pay\WeChat;

use libs\Pay\LPayCallback;
use libs\Utils\Arrays;
use libs\Utils\ServerUtil;
use libs\Utils\TimeUtil;
use libs\Utils\XMLUtil;
use libs\Validate\LValidator;

/**
 * Class LWechatPayCallback.
 * 微信支付回调处理
 * @package libs\Pay\WeChat
 */
class LWechatPayCallback extends LPayCallback
{
    /**
     * 支付附加数据
     * @var array
     */
    private $attach;

    final protected function payResultAuth()
    {
        // TODO: Change the autogenerated stub
        if (!$this->attach) {
            return false;
        }
        $val = new LValidator($this->attach);
        $val->rules([
            ['required', 'uuid'],
            ['required', 'orderSn'],
            ['required', 'sign']
        ]);
        if (!$val->validate()) {
            return false;
        }
        $newSign = LWechatPay::getAttachSign($this->attach['uuid'], $this->attach['orderSn'], $this->config['secret']);
        return $newSign == $this->attach['sign'];
    }

    /**
     * 处理微信POST数据
     * @return mixed
     */
    final protected function payResultFunc()
    {
        // TODO: Implement payResultFunc() method.
        $this->payResultOriginal = ServerUtil::serverRawData();

        if (!$xmlArray = XMLUtil::xmlDecode($this->payResultOriginal, 'xml')) {
            return false;
        }
        $xmlArray = XMLUtil::replaceCDATA($xmlArray);
        if (!$xmlArray) {
            return false;
        }

        $result = parent::payResultFunc();
        $result['tradeNumber'] = Arrays::get($xmlArray, 'out_trade_no', '');
        $result['transactionId'] = Arrays::get($xmlArray, 'transaction_id', '');
        $result['price'] = Arrays::get($xmlArray, 'total_fee', 0);
        $result['time'] = TimeUtil::parseDateToStamp(Arrays::get($xmlArray, 'time_end', 0));
        $result['bank'] = Arrays::get($xmlArray, 'bank_type');
        $result['result'] = Arrays::get($xmlArray, 'result_code') == 'SUCCESS';
        if (isset($xmlArray['attach'])) {
            parse_str($xmlArray['attach'], $this->attach);
            $result['uuid'] = Arrays::get($this->attach, 'uuid', '');
            $result['orderSn'] = Arrays::get($this->attach, 'orderSn', '');
        }
        //银行卡列表详见:https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=4_2
        return $result;
    }

    final protected function returnSuccess()
    {
        return "<?xml version='1.0' encoding='utf-8'><return_code>SUCCESS</return_code></xml>";
    }

    final protected function returnFailed()
    {
        return "<?xml version='1.0' encoding='utf-8'><return_code>FAIL</return_code></xml>";
    }
}
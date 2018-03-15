<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/6/14
 * Time: 下午5:17
 */

namespace libs\Pay\WeChat;

use Exception;
use libs\Curl\LCurl;
use libs\Pay\Error\LPayError;
use libs\Pay\ILPay;
use libs\Pay\LPayConfig;
use libs\Pay\LPayTool;
use libs\Utils\ServerUtil;
use libs\Utils\Strings;
use libs\Utils\TimeUtil;
use libs\Utils\XMLUtil;
use libs\Validate\LValidator;

/**
 * Class LWechatPay
 * 微信支付通道基类
 * @package libs\Pay\WebChat
 */
class LWechatPay implements ILPay
{
    /**
     * 最近一次错误.
     * @var string
     */
    protected $lastError = '';
    /**
     * 微信应用(公众号/应用号)id
     * @var string
     */
    protected $appId = '';
    /**
     * 微信支付商户号
     * @var string
     */
    protected $mchId = '';
    /**
     * 微信支付秘钥
     * @var string
     */
    protected $secret = '';

    /**
     * LWechatPay constructor.
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $val = new LValidator($config);
        $val->rules([
            ['required', 'appId'],
            ['required', 'mchId'],
            ['required', 'secret'],
        ]);
        if (!$val->validate()) {
            $this->lastError = LPayError::ERR_PARAMETERS;
            throw new Exception(__CLASS__ . ' config parameters not enough');
        }
        $this->appId = $config['appId'];
        $this->mchId = $config['mchId'];
        $this->secret = $config['secret'];
    }

    /**
     * 获取attach支付附加数据签名
     * @param $uuid string 统一唯一标示
     * @param $orderSn string 订单号
     * @param $secret string 支付秘钥
     * @return string
     */
    public static function getAttachSign($uuid, $orderSn, $secret)
    {
        return md5($uuid . $orderSn . $secret);
    }

    /**
     * 返回
     * @return string
     */
    protected function getTradeType()
    {
        return LPayConfig::WECHAT_TRADE_NATIVE;
    }

    /**
     * 返回最近一次操作错误.
     * @return string
     */
    public function lastError()
    {
        // TODO: Implement run() method.
        return $this->lastError;
    }

    public function run(array $data)
    {
        // TODO: Implement run() method.
        if (!$data) {
            return false;
        }
        $val = new LValidator($data);
        $val->rules([
            ['required', 'price'],
            ['required', 'orderSn'],
            ['required', 'body'],
            ['required', 'notifyUrl']
        ]);
        if (!$val->validate()) {
            $this->lastError = LPayError::ERR_PARAMETERS;
            return false;
        }

        $uuid = Strings::uuid();
        $tradeNumber = LPayTool::createTradeNumberByOrderSn($data['orderSn']);
        $newData = [
            'appid' => $this->appId,
            'mch_id' => $this->mchId,
            'nonce_str' => $uuid,
            'body' => $data['body'],
            'out_trade_no' => $tradeNumber,
            'total_fee' => $data['price'],
            'spbill_create_ip' => ServerUtil::serverIp(),
            'notify_url' => $data['notifyUrl'],
            'trade_type' => $this->getTradeType(),
        ];

        if (!isset($data['expireTime']) || !$data['expireTime']) {
            $data['expireTime'] = time() + 30 * 60;
        }
        $newData['time_expire'] = TimeUtil::parseStampToDate($data['expireTime']);

        $newData['attach'] = '<![CDATA[' . http_build_query([
                'uuid' => $uuid,
                'orderSn' => $data['orderSn'],
                'sign' => self::getAttachSign($uuid, $data['orderSn'], $this->secret)
            ]) . ']]>';

        return [
            'tradeNumber' => $tradeNumber,
            'expireTime' => $data['expireTime'],
            'result' => $this->unifiedOrder($newData)
        ];
    }


    /**
     * 微信支付统一下单
     *
     * @param $data array
     * @return bool|string
     */
    protected function unifiedOrder($data)
    {
        $data['sign'] = $this->getSign($data);

        if (!$xml = XMLUtil::xmlEncode($data, 'utf-8', 'xml')) {
            $this->lastError = LPayError::ERR_XML_ENCODE;
            return false;
        }

        $curl = new LCurl(LCurl::POST_XML);
        $result = $curl->setTimeout(5)->post(LPayConfig::URL_WECHAT_UNIFIED_ORDER, $xml);
        $result = XMLUtil::xmlDecode($result, 'xml');
        $result = XMLUtil::replaceCDATA($result);
        if ($result) {
            if (isset($result['return_code']) && $result['return_code'] == 'SUCCESS') {
                return $result;
            }
            $this->lastError = $result['return_msg'];
        } else {
            $this->lastError = LPayError::ERR_TIMEOUT;
        }
        return false;
    }


    /**
     * 获取标准微信支付签名
     *
     * @param $data array
     * @return bool|string
     */
    protected function getSign($data)
    {
        if (!$data || !is_array($data)) {
            return '';
        }

        ksort($data);
        //不允许urlencode防止回调地址或中文出现签名错误
        $signString = urldecode(http_build_query($data));
        if ($signString) {
            $stringSignTemp = $signString . '&key=' . $this->secret;
            return strtoupper(md5($stringSignTemp));
        }
        return '';
    }
}
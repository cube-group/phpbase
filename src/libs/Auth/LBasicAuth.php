<?php

namespace libs\Auth;

use libs\Utils\Arrays;
use libs\Utils\URLUtil;
use libs\Validate\LValidator;

/**
 * Class LBasicAuth.
 * http参数基础验证类(仅基于秘钥).
 * @package libs\Auth
 */
class LBasicAuth
{
    /**
     * 订单秘钥.
     */
    const SYS_SECRET = '5c0b6ce0ab09e5ebcf81e697786fe0d4';

    /**
     * 基础验证是否通过.
     * @param mixed $data
     * @return bool
     */
    public static function check($sign, $data)
    {
        if (!$data) {
            return false;
        }

        return self::get($data) == $sign;
    }


    /**
     * 获取sign签名.
     * @param $data array|string 支持对数组|url string|query string的解析
     * @return string
     */
    public static function get($data)
    {
        if (!$data || (!is_string($data) && !is_array($data))) {
            return '';
        }

        $isString = false;
        $url = false;
        if (is_string($data)) {
            $isString = true;
            if (LValidator::isUrl($data)) {
                $url = $data;
                $data = Arrays::get(parse_url($data), 'query', '');
            }
            $queryArr = [];
            parse_str($data, $queryArr);
            $data = $queryArr;
        }

        unset($data['sign']);
        ksort($data);
        if ($query = urldecode(http_build_query($data))) {
            $data = $query;
        }

        $sign = md5($data . '&secret=' . self::SYS_SECRET);
        if ($url) {
            return URLUtil::addParameter($url, ['sign' => $sign]);
        } else if ($isString) {
            return $data . '&sign=' . $sign;
        } else {
            return $sign;
        }
    }
}
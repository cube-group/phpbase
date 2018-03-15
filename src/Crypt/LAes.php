<?php

namespace libs\Crypt;

/**
 * Class LAes
 * @package libs\Encrypt
 * @author chenqionghe
 */
class LAes
{
    /**
     * 加密方式
     * @var string
     */
    private static $mode = 'aes-128-ecb';

    /**
     * 加密
     *
     * @param $data
     * @param $key
     * @return string
     */
    public static function encrypt($data, $key)
    {
        return openssl_encrypt($data, self::$mode, $key);
    }

    /**
     * 解密
     *
     * @param $data
     * @param $key
     *
     * @return string
     */
    public static function decrypt($data, $key)
    {
        return openssl_decrypt($data, self::$mode, $key);
    }
}
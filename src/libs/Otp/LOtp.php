<?php

namespace libs\Otp;

use OTPHP\Base32;
use OTPHP\TOTP;

require __DIR__ . '/../../vendor/OTPHP/autoload.php';

/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/4/18
 * Time: 下午8:36
 */

/**
 * Class LOtp.
 * @package libs\Otp
 */
class LOtp
{
    /**
     * 根据秘钥返回当前30秒范围内的TIME BASED OTP'S
     *
     * @param $secret string
     * @return int
     */
    public static function now($secret)
    {
        $secret = Base32::encode($secret);
        $totp = new TOTP($secret);
        return $totp->now();
    }

    /**
     * 根据秘钥判断6位验证码是否匹配.
     *
     * @param $secret string
     * @param $code int
     * @return bool
     */
    public static function verify($secret, $code)
    {
        $secret = Base32::encode($secret);
        $totp = new TOTP($secret);
        // OTP verified for current time
        return $totp->verify($code);
    }

    /**
     * 根据秘钥和名称生成标准google otp auth url.
     *
     * @param $secret string
     * @param $name string
     * @return string
     */
    public static function getGoogleOtpAuthUrl($secret, $name)
    {
        $secret = Base32::encode($secret);
        $totp = new TOTP($secret);
        return $totp->provisioning_uri($name);
    }
}
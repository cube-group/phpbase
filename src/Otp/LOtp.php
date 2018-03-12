<?php

namespace libs\Otp;

/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/4/18
 * Time: 下午8:36
 */
use Otp\GoogleAuthenticator;
use Otp\Otp;
use ParagonIE\ConstantTime\Encoding;

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
        $otp = new Otp();
        return $otp->totp(Encoding::base32Decode($secret));
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
        $otp = new Otp();
        return $otp->checkTotp(Encoding::base32Decode($secret), (string)$code);
    }

    /**
     * 根据秘钥和名称生成标准google otp auth url.
     *
     * @param $secret string
     * @param $mail string
     * @return string
     */
    public static function getGoogleOtpAuthUrl($secret, $mail)
    {
        return GoogleAuthenticator::getQrCodeUrl('totp', $mail, $secret);
    }
}
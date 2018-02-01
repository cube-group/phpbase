<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/6/5
 * Time: 下午8:06
 */

namespace libs\Crypt;

/**
 * Class LBinaryCrypt.
 * 基于移位操作的加解密工具类.
 * @package libs\Crypt
 */
class LBinaryCrypt
{
    /**
     * 移位加密.
     * @param $content string
     * @param int $shift
     * @return bool|string
     */
    public static function encrypt($content, $shift = 5)
    {
        if ($shift > 10) {
            return false;
        }
        if ($content) {
            $bin = self::strToBin($content, $shift);
            return base64_encode($bin);
        }
        return false;
    }

    /**
     * 移位解密
     * @param $dec string
     * @param int $shift
     * @return bool|string
     */
    public static function decrypt($dec, $shift = 5)
    {
        if ($shift > 10) {
            return false;
        }
        if ($dec) {
            $dec = base64_decode($dec);
            return self::binToStr($dec, $shift);
        }
        return false;
    }


    /**
     * 将字符串转换成十进制
     * @param $str $str
     * @param $shift int
     * @return string
     */
    private static function strToBin($str, $shift)
    {
        //1.列出每个字符
        $arr = preg_split('/(?<!^)(?!$)/u', $str);
        //2.unpack字符
        foreach ($arr as $key => $v) {
            $temp = unpack('H*', $v)[1];
            $v = base_convert($temp, 16, 10);
            $arr[$key] = $v << $shift;
        }
        return join(',', $arr);
    }

    /**
     * 十进制转换成字符串
     * @param $str string
     * @param $shift int
     * @return string
     */
    private static function binToStr($str, $shift)
    {
        $arr = explode(',', $str);
        foreach ($arr as $key => $v) {
            $v = $v >> $shift;
            $item = base_convert($v, 10, 16);
            $arr[$key] = pack("H" . strlen($item), $item);
        }
        return join('', $arr);
    }
}
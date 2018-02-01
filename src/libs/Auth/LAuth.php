<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/5/10
 * Time: 下午4:42
 */

namespace libs\Auth;

use libs\Utils\URLUtil;
use libs\Validate\LValidator;

/**
 * Class LAuth.
 * http基础验证(基于时间戳和秘钥).
 * @package libs\Auth
 */
class LAuth
{
    /**
     * 订单秘钥.
     */
    const SYS_SECRET = '5c0b6ce0ab09e5ebcf81e697786fe0d4';
    /**
     * 订单系统明文.
     */
    const SYS_KEY = '2';


    /**
     * 获取经过校验的URL地址或queryString.
     *
     * @param string $url url地址
     * @return array|string
     */
    public static function get($url = '')
    {
        $time = time();
        $data = [
            'sysKey' => self::SYS_KEY,
            'reqTimeStamp' => $time,
            'authString' => md5(self::SYS_KEY . '&' . $time . '&' . self::SYS_SECRET)
        ];

        if ($url = URLUtil::addParameter($url, $data)) {
            return $url;
        } else {
            return $data;
        }
    }


    /**
     * 访问校验
     * (data支持$_GET、$_POST或url地址)
     *
     * @param $data array|string 检测目标内容
     * @param $validDuration int 该条auth的有效时长(单位:秒)
     * @return bool
     */
    public static function check($data, $validDuration = 60)
    {
        if (!$data) {
            return false;
        }
        $query = null;
        if (is_array($data)) {
            $query = $data;
        } else {
            if (!LValidator::isUrl($data)) {
                return false;
            }
            $urlQuery = [];
            if ($query = parse_url($data)) {
                $query = explode('&', $query);
                foreach ($query as $item) {
                    list($key, $value) = explode('=', $item);
                    $urlQuery[$key] = $value;
                }
            }
            $query = $urlQuery;
        }

        if (!isset($query['sysKey']) || !isset($query['reqTimeStamp']) || !isset($query['authString'])) {
            return false;
        }
        if (time() - (int)$query['reqTimeStamp'] > $validDuration) {
            return false;
        }
        $newAuthString = md5($query['sysKey'] . '&' . $query['reqTimeStamp'] . '&' . self::SYS_SECRET);
        if ($newAuthString == $query['authString']) {
            return true;
        }
        return false;
    }
}
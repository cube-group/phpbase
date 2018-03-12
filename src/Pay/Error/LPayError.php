<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/6/14
 * Time: 下午5:13
 */

namespace libs\Pay\Error;

/**
 * Class LPayError
 * @package libs\Pay\Error
 */
class LPayError
{
    const ERR_PARAMETERS = '参数错误';

    const ERR_XML_ENCODE = 'XML组装错误';

    const ERR_TIMEOUT = '微信支付接口请求超时';
}
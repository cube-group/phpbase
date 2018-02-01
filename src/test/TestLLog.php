<?php

require __DIR__ . '/../libs/autoload.php';

use libs\Curl\LCurl;
use \libs\Log\LLog;

class TestLLog
{
    public function testCommon()
    {
        //初始化日志
        LLog::init('test', __DIR__);
        //debug日志
        LLog::info('Action-A', __FILE__, 'HelloWorld');
        LLog::info('Action-B', __FILE__, 'Json:', ['status' => 'Y']);
        //错误日志
        LLog::error('Action-B', __FILE__, 'SendData:', ['a' => '123123']);
        //...logic
        //日志压栈存储
        LLog::flush();
    }

    /**
     * 设置每次都刷日志
     */
    public function testAutoFlush()
    {
        //初始化日志
        LLog::init('test', __DIR__);
        //设置每次都刷日志
        LLog::setAutoFlush(true);
        //debug日志
        LLog::info('Action-C', __FILE__, 'HelloWorld');
        LLog::info('Action-D', __FILE__, 'Json:', ['status' => 'Y']);
        //错误日志
        LLog::error('Action-D', __FILE__, 'SendData:', ['a' => '123123']);
    }

    public function testRequestId()
    {
        $url = 'TestLLog1';
        var_dump(\libs\Validate\LValidator::isUrl($url));
        $curl = new LCurl();
        $curl->setGlobalLogId(true);
        $result = $curl->get($url);

        var_dump($result);
    }
}

$test = new TestLLog();
$test->testCommon();
$test->testAutoFlush();
//$test->testRequestId();

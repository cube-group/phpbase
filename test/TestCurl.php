<?php

use libs\Curl\LCurl;

require __DIR__.'/../src/autoload.php';

/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/3/17
 * Time: 下午3:58
 */
class TestCurl
{
    private $curl;

    /**
     * TestCurl2 constructor.
     */
    public function __construct()
    {
        $this->curl = new LCurl();
    }

    public function go()
    {
        $url = 'http://www.baidu.com';
        dump($this->curl->post($url, ['mobile' => 18866668888, 'code' => 123456]));
    }
}

$c = new TestCurl();
$c->go();
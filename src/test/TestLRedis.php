<?php

use libs\Cache\LRedis;
use libs\Service\LSConfig;

require __DIR__ . '/../libs/autoload.php';

/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/7/14
 * Time: 下午9:27
 */
class TestLRedis
{
    private $redis;

    public function __construct()
    {
        $this->redis = new LRedis([]);
    }

    public function get()
    {
        dump($this->redis->hGetAll('ssid-32f84c1912100c85eaf6c2db619d3ee6'));
    }
}

$t = new TestLRedis();
$t->get();
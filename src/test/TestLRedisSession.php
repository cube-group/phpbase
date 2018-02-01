<?php

require __DIR__ . '/../libs/autoload.php';

use libs\Service\LSConfig;
use \libs\Session\LRedisSession;

/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/3/13
 * Time: 上午11:06
 */
class TestLRedisSession
{
    private $session;

    public function __construct()
    {
        $this->session = new LRedisSession([]);
    }

    public function set()
    {
        dump($this->session->set('hello', time()));
    }

    public function get()
    {
        dump($this->session->get('hello'));
        dump($this->session->getTTL());
    }
}

$t = new TestLRedisSession();
$t->set();
$t->get();
## LRedisSession通过redis存储用户session信息
```
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
        define('APP_MODE', 'develop3');
        $config = LSConfig::get()->redis->name('6501')->toArray();
        $this->session = new LRedisSession($config);
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
```
<?php

use libs\Queue\LHttpRabbitMQ;
use libs\Queue\LRabbitMQ;
use libs\Queue\LRedisMQ;

require __DIR__ . '/../src/autoload.php';

/**
 * Class TestLRabbit.
 * 测试通过.
 */
class TestLRabbitMQ
{
    /**
     * @var \libs\Queue\IMQ
     */
    private $queue;

    public function __construct()
    {
        $this->queue = new LRabbitMQ([
            'host' => 'host',
            'port' => '5672',
            'login' => 'username',
            'password' => 'password',
            'database' => 'async_exchange',
            'vhost' => 'async'
        ]);
    }

    public function product()
    {
        $rt = $this->queue->product(time(), 'LOG_COMMON');
        var_dump($rt);
    }

    public function consume()
    {
        $rt = $this->queue->consume('LOG_COMMON');
        var_dump($rt);
        $this->queue->consumeStatus(true);
    }
}

//$t = new TestLRabbitMQ();
//$t->product();
//$t->consume();


/**
 * Class TestLHttpRabbitMQ.
 */
class TestLHttpRabbitMQ
{
    /**
     * @var \libs\Queue\IMQ
     */
    private $queue;

    /**
     * TestLHttpRabbitMQ constructor.
     */
    public function __construct()
    {
        $this->queue = new LHttpRabbitMQ([
            'host' => '127.0.0.1',
            'port' => '15672',
            'login' => 'guest',
            'password' => 'guest',
            'vhost' => 'test'
        ]);
    }

    public function product()
    {
        $rt = $this->queue->product((string)time(), 'test-test');
        var_dump($rt);
    }

    public function consume()
    {
        $rt = $this->queue->consume('test-test', 5);
        var_dump($rt);
    }
}

$t2 = new TestLHttpRabbitMQ();
$t2->product();
$t2->consume();


/**
 * Class TestLRedisMQ.
 */
class TestLRedisMQ
{
    /**
     * @var \libs\Queue\IMQ
     */
    private $queue;

    /**
     * TestLHttpRabbitMQ constructor.
     */
    public function __construct()
    {
        $this->queue = new LRedisMQ([
            'host' => '127.0.0.1',
            'port' => '6379',
            'password' => 'password',
            'database' => 0
        ]);
    }

    public function product()
    {
        $rt = $this->queue->product((string)time(), 'LOG_COMMON');
        var_dump($rt);
    }

    public function consume()
    {
        $rt = $this->queue->consume('LOG_COMMON', 3);
        var_dump($rt);
    }
}

//$t3 = new TestLRedisMQ();
//$t3->product();
//$t3->consume();
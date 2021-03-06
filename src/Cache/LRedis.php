<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/13
 * Time: 下午12:20
 */

namespace libs\Cache;

//extension check.
if (!extension_loaded('redis')) {
    throw new \Exception('Extension redis is not exist!');
}

use libs\Validate\LValidator;
use \Redis;
use \Exception;
use \RedisException;

/**
 * Class LRedis
 *
 * @method bool expire($key, $ttl)
 * @method int type($key)
 * @method mixed set(string $key, string $value)
 * @method mixed get(string $key)
 * @method mixed lPush(string $key, string $value)
 * @method mixed rPop(string $key)
 * @method mixed hSet(string $key, string $field, string $value)
 * @method mixed hGet(string $key, string $field)
 * @method mixed hGetAll(string $key)
 * @method int hLen(string $key)
 * @method int hDel(string $key, $hashKey1, $hashKey2 = null, $hashKeyN = null)
 * @method bool hExists(string $key, $hashKey)
 * @method bool hMset($key, $hashKeys)
 * @method array hMGet($key, $hashKeys)
 * @method bool setex(string $key, int $ttl, string $value)
 * @method bool setnx(string $key, string $value)
 * @method int del(string|array $key1, string $key2 = null, string $key3 = null)
 * @method int ttl(string $key)
 *
 * @package libs\Cache
 */
class LRedis extends LCache
{
    /**
     * 限制函数名.
     * @return array
     */
    public static function limits()
    {
        return [
            'gbRewriteAOF', 'gbSave', 'config', 'dbSize', 'flushAll', 'flushDb', 'info', 'lastSave', 'resetStat', 'save', 'slaveOf', 'time', 'slowLog',
            'pSubscribe', 'publish', 'subscribe', 'pubSub',
            'eval', 'evalSha', 'script', 'getLastError', 'clearLastError'
        ];
    }


    /**
     * 数据库连接对接
     * @var Redis
     */
    protected $redis;

    /**
     * DataStore constructor.
     *
     * @param $options array 连接参数
     * array(
     *      'host'=>'localhost',
     *      'port'=>4396,
     *      'database'=>0,
     *      'password'=>''
     * );
     * @return mixed
     */
    public function __construct($options = [])
    {
        $this->configure($options);
    }

    /**
     * DataStore constructor.
     *
     * @param $options array 连接参数
     * array(
     *      'host'=>'localhost',
     *      'port'=>4396,
     *      'database'=>0,
     *      'password'=>''
     * );
     *
     * @return mixed
     * @throws Exception
     */
    public function configure($options)
    {
        $val = new LValidator($options);
        $val->rule([
            'required', ['host', 'port', 'database', 'password']
        ]);
        if (!$val->validate()) {
            throw new Exception('options parameters not enough');
        }

        if (!isset($options['timeout'])) {
            $options['timeout'] = 10;
        }
        try {
            $this->redis = new Redis();
            $this->redis->connect($options["host"], $options["port"], $options['timeout']);
            if (isset($options['password'])) {
                $this->redis->auth($options["password"]);
            }
            if (isset($options['database'])) {
                $this->redis->select($options['database']);
            }
        } catch (RedisException $e) {
            $this->close($e->getMessage());
        } catch (Exception $e) {
            $this->close($e->getMessage());
        }
    }

    /*
     * @use 关闭redis连接
     */
    public function close($error = '')
    {
        parent::close($error);

        if ($this->redis) {
            $this->redis->close();
            $this->redis = null;
        }
    }


    /**
     * @param $name
     * @param $arguments
     * @return bool|mixed
     */
    public function __call($name, $arguments)
    {
        if ($this->redis) {
            if (method_exists($this->redis, $name) && !in_array($name, self::limits())) {
                return call_user_func_array([$this->redis, $name], $arguments);
            }
        }
        return false;
    }
}
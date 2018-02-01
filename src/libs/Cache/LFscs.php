<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 2017/12/15
 * Time: 下午2:18
 */

namespace libs\Cache;

use libs\Service\Basic\LSResult;
use libs\Service\LSCache;

/**
 * Class LFscs
 * Foryou stable cache system.
 * ************************************************
 * ************** Fscs K-V 存储结构 ****************
 * ****** module不存在时的结构Redis String **********
 * ************* key: name-key ********************
 * ************* value: value *********************
 * ************************************************
 * ******* module存在时的结构Redis Hash *************
 * ************* key: name-module *****************
 * ************* field: key ***********************
 * ************************************************
 * @package libs\Cache
 */
class LFscs extends LSResult
{
    /**
     * 是否启动zlib解压缩内容
     * @var bool
     */
    protected $zlib;
    /**
     * 一级业务线名称
     * @var string
     */
    protected $name;
    /**
     * cache有效时长(单位:秒)
     * @var int
     */
    protected $expire = 86400;
    /**
     * 二级检索
     * @var string
     */
    protected $module;

    /**
     * LFscs constructor.
     * @param $name string appName业务线名称
     * @param int $expire 有效时长(单位:秒)
     */
    public function __construct($name, $expire = 86400)
    {
        $this->name = $name;
        $this->expire = $expire;
    }

    /**
     * 获取hash组合key
     * @return bool|string
     */
    protected function getHashKey()
    {
        if (!$this->name) {
            return false;
        }
        if (!$this->module) {
            return false;
        }
        return "{$this->name}-{$this->module}";
    }

    /**
     * 获取string组合key
     * @param $key string
     * @return bool|string
     */
    protected function getStringKey($key)
    {
        if (!$this->name) {
            return false;
        }
        return "{$this->name}-{$key}";
    }

    /**
     * 确认二级模型内容
     * @param $value string
     * @return $this
     */
    public function module($value = null)
    {
        $this->module = $value;
        return $this;
    }

    /**
     * 是否启动zlib解压缩
     * @return $this
     */
    public function zlib()
    {
        $this->zlib = true;
        return $this;
    }

    /**
     * 设置超时时间(单位:秒)
     * @param int $time
     * @return $this
     */
    public function expire($time)
    {
        $this->expire = $time;
        return $this;
    }

    /**
     * 获取缓存信息
     * @param $keys string|array
     * @return array|null|bool
     */
    public function get($keys = null)
    {
        self::setResult(__FUNCTION__, 'params', ['keys' => $keys, 'module' => $this->module, 'name' => $this->name]);

        if ($keys && !is_array($keys) && !is_string($keys)) {
            return false;
        }
        if ($this->module) {
            return $this->getFromHash($keys);
        } else {
            return $this->getFromString($keys);
        }
    }

    /**
     * 设置单条缓存信息
     * @param $key string
     * @param $value array
     * @return bool
     */
    public function set($key, $value)
    {
        self::setResult(__FUNCTION__, 'params', ['key' => $key, 'module' => $this->module, 'name' => $this->name]);

        if (!$key || !$value) {
            return false;
        }
        $value = $this->getEncodeValue($value);
        if ($value === false) {
            return false;
        }
        if ($this->module) {
            $redisKey = $this->getHashKey();
            $setResult = LSCache::cache()->hSet($redisKey, $key, $value);
        } else {
            $redisKey = $this->getStringKey($key);
            $setResult = LSCache::cache()->set($redisKey, $value);
        }
        if ($setResult === false) {
            return false;
        }
        LSCache::cache()->expire($redisKey, $this->expire);
        return true;
    }

    /**
     * 移除属性
     * @param $key string
     * @return int
     */
    public function delete($key = null)
    {
        self::setResult(__FUNCTION__, 'params', ['key' => $key, 'module' => $this->module, 'name' => $this->name]);

        if ($this->module) {
            $hashKey = $this->getHashKey();
            if ($key) {
                return LSCache::cache()->hDel($hashKey, $key);
            }
            return LSCache::cache()->del($hashKey);
        } else if ($key) {
            $stringKey = $this->getStringKey($key);
            return LSCache::cache()->del($stringKey);
        } else {
            return false;
        }
    }

    /**
     * 从string结构中获取值
     * @param $key string
     * @return mixed
     */
    private function getFromString($key)
    {
        if (!$key) {
            return false;
        }
        if (is_array($key) || is_object($key)) {
            return false;
        }
        if (!$stringKey = $this->getStringKey($key)) {
            return false;
        }
        $result = LSCache::cache()->get($stringKey);
        if ($result === false) {
            return false;
        }
        return $this->getDecodeResult($result);
    }

    /**
     * 从hash结构中获取值
     * @param null|array|string $keys
     * @return bool|null|array
     */
    private function getFromHash($keys = null)
    {
        if (!$hashKey = $this->getHashKey()) {
            return false;
        }
        $result = null;
        if (!$keys) {
            $result = LSCache::cache()->hGetAll($hashKey);
        } else if (is_array($keys)) {
            $result = LSCache::cache()->hMGet($hashKey, $keys);
        } else if (is_string($keys)) {
            $result = LSCache::cache()->hGet($hashKey, $keys);
        } else {
            return false;
        }
        if (is_array($result)) {
            foreach ($result as $key => $item) {
                $result[$key] = $this->getDecodeResult($item);
            }
            return $result;
        } else {
            return $this->getDecodeResult($result);
        }
    }

    /**
     * 将set数据进行encode
     * @param $value mixed
     * @return bool
     */
    private function getEncodeValue($value)
    {
        if ($value === false) {
            return false;
        }
        if (is_array($value)) {
            $value = @json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        if (!$value) {
            return false;
        }
        if ($this->zlib) {
            $t = microtime(true);
            if ($zLibValue = @gzcompress($value)) {
                self::setResult(
                    __FUNCTION__, 'gzcompress time',
                    [
                        'time' => (int)((microtime(true) - $t) * 1000),
                        'before' => strlen($value), 'after' => strlen($zLibValue)
                    ]
                );
                $value = $zLibValue;
            }
        }
        return $value;
    }

    /**
     * 将数据进行decode后的数据
     * @param $result mixed
     * @return mixed|string
     */
    private function getDecodeResult($result)
    {
        if ($this->zlib) {
            $t = microtime(true);
            if ($decodeItem = @gzuncompress($result)) {
                self::setResult(
                    __FUNCTION__, 'gzuncompress time',
                    [
                        'time' => (int)((microtime(true) - $t) * 1000),
                        'before' => strlen($result), 'after' => strlen($decodeItem)
                    ]
                );
                $result = $decodeItem;
            }
        }
        if ($jsonArray = @json_decode($result, true)) {
            $result = $jsonArray;
        }
        return $result;
    }
}
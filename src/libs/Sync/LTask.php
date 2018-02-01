<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/3/10
 * Time: 下午2:50
 */

namespace libs\Sync;

/**
 * Class LTask.
 * @package libs\Sync
 */
class LTask
{
    /**
     * 任务体列表.
     * @var array
     */
    private $list;

    /**
     * 任务链执行结果存储.
     * @var array
     */
    private $results = [];

    /**
     * 任务链过程中最近一次出现错误的步骤name值.
     * @var string
     */
    private $errorName = '';

    /**
     * 任务链过程中最近一次出现错误的步骤标号.
     * @var int
     */
    private $errorIndex = -1;

    /**
     * 原始数据源.
     * @var null
     */
    private $input = null;

    /**
     * LTask constructor.
     * @param $list array
     */
    public function __construct($data, $list)
    {
        $this->input = $data;
        $this->list = $list;

        $this->next();
    }


    /**
     * 开始执行任务链.
     */
    private function next()
    {
        $step = current($this->list);
        if ($step && isset($step['call']) && isset($step['name'])) {
            list($obj, $methodName) = $step['call'];
            if (method_exists($obj, $methodName)) {

                $stepName = $step['name'];
                $must = isset($step['must']) ? $step['must'] : false;

                $result = call_user_func_array($step['call'], [$this]);
                $this->results[$stepName] = $result;
                if (!$result) {
                    $this->errorName = $stepName;
                    $this->errorIndex = key($this->list);
                }
                if(!($must && !$result)){
                    next($this->list);
                    $this->next();
                    return;
                }
            }
        }

        //结束任务链
    }

    /**
     * 获取任务链数据处理结果.
     * @param null $key
     * @return array|bool|mixed
     */
    public function output($key = null)
    {
        if (!$this->results) {
            return false;
        }
        if ($key) {
            return $this->results[$key];
        }
        return $this->results;
    }

    /**
     * 获取任务链初始数据源.
     * @return null
     */
    public function input()
    {
        return $this->input;
    }

    /**
     * 获取任务链过程中最近一次出现错误的步骤name值.
     * @return string
     */
    public function lastErrorName()
    {
        return $this->errorName;
    }

    /**
     * 获取任务链过程中最近一次出现错误的步骤标号.
     * @return string
     */
    public function lastErrorIndex()
    {
        return $this->errorIndex;
    }
}
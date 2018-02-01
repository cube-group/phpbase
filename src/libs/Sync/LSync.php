<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/3/10
 * Time: 下午2:49
 */

namespace libs\Sync;

/**
 * Class LSync.
 * 同步任务链.
 * @package libs\Sync
 */
class LSync
{
    /**
     * 创建任务链实例.
     * @param $data array 任务初始数据
     * @param $list array 任务链队列
     * @return LTask
     */
    public static function task($data, $list)
    {
        /**
         * $list单元标准['c'=>'MyClass','m'=>'call','name'=>'t1','line'=>1]
         * c为完整的className,
         * m为完整的类函数名称,且函数为function m(LTask $task){...}
         * name为该步骤执行完毕后在对应的$task->data->name;
         * line为该步骤返回false后是否能够继续执行,line为true则会中断失败直接调用$end
         */
        return new LTask($data, $list);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 2017/12/15
 * Time: 下午2:57
 */

namespace libs\Cache;

/**
 * Class LFscsNull
 * @package libs\Cache
 */
class LFscsNull
{
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        switch ($name) {
            case "db":
            case "module":
                return $this;
            default:
                return false;
        }
    }
}
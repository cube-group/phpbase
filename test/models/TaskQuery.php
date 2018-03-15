<?php

namespace test\models;

/**
 * Class TaskQuery
 */
class TaskQuery extends \libs\Orm\LActiveQuery
{
    /**
     * 命名范围(自定义查询条件)
     *
     * @param $value
     * @return $this
     */
    public function name($value)
    {
        return $this->where("name='{$value}'");
    }

}
<?php

namespace test\models;

use libs\Orm\LActiveRecord;

/**
 * Class Task
 * @property $id
 * @property $name
 * @property $ip
 * @property $port
 * @property $create_time
 */
class Task extends LActiveRecord
{
    public function tableName()
    {
        return "task";
    }

    public function find()
    {
        $activeQuery = new TaskQuery($this->_db, $this->trueTableName());
        $activeQuery->setModelClass(get_called_class());
        return $activeQuery;
    }


    public function test()
    {
        return "test method";
    }

    public function getA()
    {
        return "a";
    }
}
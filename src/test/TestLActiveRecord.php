<?php

require __DIR__ . '/../libs/autoload.php';

use \libs\Orm\LDB;
use test\models\Task;

/**
 * Class TestLActiveRecord
 */
class TestLActiveRecord
{
    /**
     * @var LDB
     */
    private $db;

    /**
     * TestLDB constructor.
     */
    public function __construct()
    {
        $config = [
            'host' => '127.0.0.1',
            'port' => 3306,
            'username' => 'root',
            'password' => '111111',
            'database' => 'baseservice',
            'prefix' => 'p_'
        ];
        $this->db = LDB::create($config);
    }

    /**
     * 测试
     */
    public function exec()
    {
        $taskModel = new Task($this->db);

        $arQuery = $taskModel->find()->where("id=2 AND name='test'");
        $this->printAll("find()返回一个LActiveQuery对象, 支持所有LDBKernel的链式查询方法", $arQuery);


        /** @var Task $taskObj */
        $taskObj = $taskModel->find()->where("id=2")->one();
        $this->printAll("one()返回AR对象", $taskObj);

        $taskArray = $taskModel->find()->asArray()->where("id=1")->one();
        $this->printAll("asArray()->one()返回数组", $taskArray);

        $taskObjs = $taskModel->find()->select();
        $this->printAll("select()返回AR对象数组", $taskObjs);

        $taskArrays = $taskModel->find()->asArray()->select();
        $this->printAll("asArray()->select()返回多维数组", $taskArrays);

        $taskQuery = $taskModel->find()->name("测试机(123.57.157.78)");
        $this->printAll("自定义查询条件的name()", $taskQuery->one());

        $this->printAll("对象转数组方法toArray()", $taskObj->toArray());

        $this->printAll("执行对象自定义方法test()", $taskObj->test());

        $this->printAll("支持数组形式访问\$taskObj['name']", $taskObj['name']);

        $this->printAll("支持属性形式访问\$taskObj->name", $taskObj->name);

        $foreach = [];
        foreach ($taskObj as $key => $value) {
            $foreach[] = "{$key}--{$value}";
        }
        $this->printAll("支持foreach", $foreach);

        $this->printAll("toJson转json", $taskObj->toJson());

        $this->printAll("支持json_encode", json_encode($taskObj));

        $this->printAll("支持序列化", serialize($taskObj));

        $this->printAll("支持反序列化", unserialize(serialize($taskObj)));

        $this->printAll("支持count函数, 返回属性个数", count($taskObj));

        $taskObj->setAttribute('ip', '127.0.0.2');
        $this->printAll("setAttribute()设置一个属性", $taskObj->toArray());

        $taskObj->setAttributes(['ip' => '127.0.0.3', 'name' => 'test setAttributes']);
        $this->printAll("setAttributes()批量设置属性", $taskObj->toArray());

        $this->printAll("getOldAttributes()获取save修改之前的所有属性", $taskObj->getOldAttributes());

        $this->printAll("getDirtyAttributes()获取修改的属性", $taskObj->getDirtyAttributes());

        $this->printAll("save()保存到数据库, 主键存在新增,不存在插入", $taskObj->save());

    }

    /**
     * @param $title
     * @param array ...$args
     */
    private function printAll($title, ...$args)
    {
        echo "<h2>{$title}</h2>";
        foreach ($args as $arg) {
            var_dump($arg);
        }
    }

}


spl_autoload_register(function ($className) {
    $namespace = 'test';

    if (strpos($className, $namespace) === 0) {
        $className = str_replace($namespace, '', $className);
        $fileName = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($fileName)) {
            require($fileName);
        }
    }
});

$test = new TestLActiveRecord();
$test->exec();
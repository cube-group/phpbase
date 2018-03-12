<?php

require __DIR__ . '/../libs/autoload.php';

use \libs\Orm\LDB;

class TestLDB
{
    public function exec()
    {
        $config = [
            'host' => 'localhost',
            'port' => 3306,
            'username' => 'root',
            'password' => '111111',
            'database' => 'base',
            'prefix' => ''
        ];

        $db = LDB::create($config, $config);

        $result = $db->table('list')->where(['warning' => 1])->one();
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('list')->join('list2')->on('list.id=list2.id')->order('list.id desc')->select();
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('list')->join('list2')->on('list.id=list2.id')->select(['list.id', 'list2.user']);
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('list')->join('list2')->on('list.id=list2.id')->one();
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('list')->join('list2')->on('id=1123131')->one('user');
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('list2')->insert(['type' => 1, 'user' => 'linnn']);
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('list2')->insertMulti(['type', 'user'], [[2, time() . '-hello'], [3, time() . '-hello'], [3, time() . '-hello']]);
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('list2')->where(['user' => 'a'])->update(['type' => 1]);
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('list2')->insert(['type' => 1, 'user' => 'linnn'], ['user' => 'abc']);
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('list2')->where(['user' => 'linnn'])->select('type');
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('sum_count')->count();
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());

        $result = $db->table('sum_count')->sum('value');
        var_dump($result);
        $this->printSQL($db->lastSql(), $db->lastInsertId(), $db->lastError());
    }

    private function printSQL(...$args)
    {
        $newArr = [];
        foreach ($args as $arg) {
            $newArr[] = is_array($arg) ? json_encode($arg) : $arg;
        }
        echo join(' | ', $newArr) . '<br>';
    }


    /**
     * 测试事务嵌套
     */
    public function testTransaction()
    {
        $db = LDB::create([
            'host' => '127.0.0.1',
            'port' => 3306,
            'username' => 'root',
            'password' => '111111',
            'database' => 'base',
            'prefix' => ''
        ]);

        $one = $two = $three = [];
        $sqlOne = "UPDATE p_task set name='A' WHERE id = 1";
        $sqlTwo = "UPDATE p_task set name='B' WHERE id = 2";
        $sqlThree = "UPDATE p_task set name='C' WHERE id = 3";
        try {
            $one['begin'] = $db->beginTransaction();
            $one[$sqlOne] = $db->exec($sqlOne);

            try {
                $two['begin'] = $db->beginTransaction();
                $two[$sqlTwo] = $db->exec($sqlTwo);

                try {
                    $three['begin'] = $db->beginTransaction();
                    $three[$sqlThree] = $db->exec($sqlThree);
                    throw new \Exception('事务3退出');
                    $three['commit'] = $db->commit();
                } catch (\Exception $e) {
                    $three['rollback'] = $db->rollBack();
                }

                $two['commit'] = $db->commit();
            } catch (\Exception $e) {
                $two['rollback'] = $db->rollBack();
            }
            $one['commit'] = $db->commit();
        } catch (\Exception $e) {
            $db->rollBack();
        }
        dump($one, $two, $three);
    }
}

$test = new TestLDB();
$test->exec();
$test->testTransaction();
## LSync+LTask 让你的代码从这一刻具备哲学观
### Attension
* LSync倡导【函数】为单元进行执行来约束开发者的业务开发;
* LSync建议一切中断或者结束都要在end的匿名函数中处理;
* LSync不是万能的,用好它让同步式编程非常爽快,用的不好你会很头疼的;
### Demo
我们以两个业务进行解耦拆分,工作任务:Work,生活:Live。
```
<?php

require __DIR__ . '/../libs/autoload.php';

use \libs\Sync\LSync;
use \libs\Sync\LTask;


/**
 * Class TaskWork.
 * 工作任务.
 */
class Work
{
    public function doMorning(LTask $task)
    {
        return true;
    }

    public function doAfternoon(LTask $task)
    {
        return false;
    }
}


/**
 * Class TaskLive.
 * 生活组成.
 */
class Live
{
    public function doBreakfast(LTask $task)
    {
        return true;
    }

    public function doLaunch(LTask $task)
    {
        return false;
    }
}


class MyModel
{
    private $live;
    private $work;

    public function __construct()
    {
        $this->live = new Live();
        $this->work = new Work();
    }

    public function go()
    {
        $input = ['hello' => 'world'];

        $list = [
            ['call' => [$this->live, 'doBreakfast'], 'name' => 'breakfast', 'must' => 1],
            ['call' => [$this->work, 'doMorning'], 'name' => 'morning', 'must' => 1],
            ['call' => [$this->live, 'doLaunch'], 'name' => 'launch', 'must' => 0],
            ['call' => [$this->work, 'doAfternoon'], 'name' => 'afternoon', 'must' => 1]
        ];

        $task = LSync::task($input, $list);
        var_dump($task->input());
        var_dump($task->output());
        var_dump($task->lastErrorName());
        var_dump($task->lastErrorIndex());
    }
}

$model = new MyModel();
$model->go();
```
### 必要参数详解
* $input 代表的是启动task之前的原始数据,多为$_POST或$_GET
* $list为二维数组,row的{'call'=>'实例+函数名','name'=>'结果key','must'=>'是否必须继续'}
* LTask->input()获得原始数据;
* LTask->ouput()获得每个步骤得到的数据;
* LTask->lastErrorName()最近一次错误步骤的name;
* LTask->lastErrorIndex()最近一次错误步骤的序号;






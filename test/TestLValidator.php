<?php

use libs\Validate\LValidator;

require __DIR__ . '/../vendor/autoload.php';

/**
 * LValidator验证器使用示例
 *
 * Class TestCarbon
 * @author chenqionghe
 */
class TestLValidator
{

    /**
     * 自定义错误消息
     */
    public function TestMessage()
    {
        dump("自定义错误消息");
        $data = ['name' => '', 'age' => ''];
        $label = ['name' => '姓名'];
        $val = new LValidator($data, $label);
        $val->rules([
            ['required', "name", 'message' => "姓名不能为空！"],
            ['required', "age", 'message' => "年龄不能为空！"]
        ]);
        if (!$val->validate()) {
            dump($val->errorString());
        }
    }

    /**
     * 测试required
     */
    public function TestRequired()
    {
        dump("requied：skipEmpty可以跳过空验证，但是必传字段");

        $data = [
            'name' => '',
            'name_isset' => '',
        ];
        $val = new LValidator($data);
        $val->rules([
            ['required', "name", 'message' => '姓名不能为空',],
            ['required', "name_isset", 'message' => 'name_isset字段必须有，可以为空', 'skipEmpty' => false],
        ]);

        if (!$val->validate()) {
            dump($val->errorString());
        }
    }


    public function exe()
    {
        //快速验证单个规则
        $this->printAll('验证url', LValidator::isUrl("http://www.baidu.com"));
        $this->printAll('验证邮箱', LValidator::isEmail("abc@abc.com"));
        $this->printAll('验证英文字母', LValidator::isAlpha('abc'));
        $this->printAll('验证英文字母+数字', LValidator::isAlphaNum('123abc'));
        $this->printAll('验证英文字母+数字+破折号+下划线', LValidator::isSlug('123abc_'));
        $this->printAll('验证日期格式', LValidator::isDate('2010'));
        $this->printAll('验证大陆电话', LValidator::isTel('2010'));
        $this->printAll('验证车牌号', LValidator::isCarPlate('abcd'));
        $this->printAll('验证银行卡号', LValidator::isBankCard('123456'));

        //批量验证
        $data = [
            'name' => 'chenqionghe',
            'age' => '18',
            'money' => '一百',
            'email' => 'abc',
            'alphaTest' => 'ads111',
            'boolTest' => 'bool',
            'containsTest' => 'containsTest',
            'ipTest' => 'ipTest',
            'lengthTest' => 'lengthTest',
            'inTest' => 'inTest',
            'notInTest' => 'notInTest',
            'urlTest' => 'urlTest',
            'dateTest' => 'dateTest',
            'dateAfterTest' => '2017-05-01',
            'dateBeforeTest' => '2017-05-01',
            'sameTest' => 'cqh',
            'sameTest2' => 'cqh',
            'regexTest' => 'abc',
            'muiti' => [
                'name' => '',
            ]
        ];
        $labels = [
            'name' => '名字',
            'age' => '年龄',
            'testRequired' => '测试必传',
            'dateTest' => '日期测试',
        ];
        $validator = new  LValidator($data, $labels);
        //添加一条验证规则,验证必传
        $validator->rule(['required', 'testRequired']);
        //批量添加验证规则
        $validator->rules([
            //验证整数
            ['integer', 'money',],
            //验证数字, 支持指定message参数指定自定义显示, 指定label自定义字段标签
            ['numeric', 'money', 'message' => '{field}必须是数字(自定义显示)'],
            //验证bool值
            ['boolean', 'boolTest'],
            //验证邮箱
            ['email', 'email'],
            //验证字母
            ['alpha', 'alphaTest'],
            //验证字符串包含
            ['contains', 'containsTest', 'abc'],
            //验证ip
            ['ip', 'ipTest'],
            //验证长度
            ['length', 'lengthTest', ">=", 20],
            //验证值范围
            ['in', 'inTest', ['a', 'b', 'c']],
            //验证值不在范围
            ['notIn', 'notInTest', ['notInTest']],
            //验证url地址
            ['url', 'urlTest'],
            //验证日期格式
            ['date', 'dateTest'],
            //验证日期必须在指定日期之后
            ['dateAfter', 'dateAfterTest', '2017-10-01'],
            //验证日期必须在指定日期之前
            ['dateBefore', 'dateBeforeTest', '2017-05-01'],
            //验证值必须相同
            ['same', 'sameTest', 'name'],
            //对比验证
            ['compare', 'age', ">", 18],//age > 18
            //自定义正则验证
            ['regex', 'regexTest', '/^cqh.*/'],
            //指定php函数验证
            ['func', 'name', 'is_array'],
            //指定类方法验证
            ['func', 'name', [\libs\Utils\Arrays::class, 'isMultidim']],
            //闭包验证
            [function ($field, $value) {
                return $value == 'helloWorld';
            }, 'name', 'message' => '名字不是helloWorld'],
            //.给数组内部元素添加规则
            ['required', 'multi.name'],

        ]);
        //手动设置字段映射标签
        $validator->labels([
            'email' => '邮箱地址',
            'alphaTest' => '数字测试',
            'boolTest' => '布尔测试',
        ]);
        //为验证消息自定义错误格式和自定义标签
        $validator->rule(['required', 'testRequired2'])->message("{field}不能为空(自定义格式)")->label('自定义标签testRequired2');
        //验证触发方法
        if ($validator->validate()) {
            $this->printAll("验证成功");
        } else {
            $this->printAll("验证失败, 错误信息", $validator->errors());
        }
    }

    /**
     * @param $title
     * @param array ...$args
     */
    private function printAll($title, ...$args)
    {
        echo "<h3>{$title}</h3>";
        foreach ($args as $arg) {
            var_dump($arg);
        }
    }
}

spl_autoload_register(function ($className) {
    $namespace = 'test';

    if (strpos($className, $namespace) === 0) {
        $className = str_replace($namespace, '', $className);
        $fileName = __DIR__ . 'TestLValidator.php/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($fileName)) {
            require($fileName);
        }
    }
});
$c = new TestLValidator();
//$c->exe();
$c->TestMessage();
$c->TestRequired();
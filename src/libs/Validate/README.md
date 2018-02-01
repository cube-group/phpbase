## LValidator是一个简单的验证类

#使用demo 快速验证单个规则 
```
LValidator::isUrl("http://www.baidu.com"));
LValidator::isEmail("abc@abc.com"));
LValidator::isAlpha('abc'));
LValidator::isAlphaNum('123abc'));
LValidator::isSlug('123abc_'));
LValidator::isDate('2010'));
LValidator::isTel('12345'));
LValidator::isCarPlate('abcd'));
LValidator::isBankCard('123456'));
```

##使用demo 通过rule或rules添加验证规则
构造函数传入验证数据
```
$validator = new  LValidator(['name' => '', 'email' => 'abc', 'age' => '十八']);
$validator->rule(['email', 'email']);
$validator->rules([
    ['required', 'name'],
    ['integer', 'age'],
]);
if ($validator->validate()) {
    //验证通过
} else {
    var_dump($validator->errors());//打印失败信息
}
```
输出
```
array (size=3)
  'email' => 
    array (size=1)
      0 => string 'Email是无效邮箱, 非法值abc' (length=34)
  'name' => 
    array (size=1)
      0 => string 'Name不能为空' (length=16)
  'age' => 
    array (size=1)
      0 => string 'Age只能是整数(0-9)' (length=23)
```

##使用demo 设置字段标签
设置提示字段标签, 如name显示为名字, 通过构造方法传字段标签数组
```
$validator = new  LValidator(
    ['name' => '', 'email' => 'abc', 'age' => '十八'],//验证数据
    ['name' => '用户名', 'email' => '我的邮箱', 'age' => '年龄']//字段标签
);
$validator->rules([
    ['required', 'name'],
    ['integer', 'age'],
    ['email', 'email']
]);
if ($validator->validate()) {
    //验证通过
} else {
    var_dump($validator->errors());//打印失败信息
}
```
输出
```
array (size=3)
  'name' => 
    array (size=1)
      0 => string '用户名不能为空' (length=21)
  'age' => 
    array (size=1)
      0 => string '年龄只能是整数(0-9)' (length=26)
  'email' => 
    array (size=1)
      0 => string '我的邮箱是无效邮箱, 非法值abc' (length=41)
```
###使用demo 使用.验证数组内部元素
```
$data = [
    'a' => 'b',
    'demo' => [
        'name' => '',
        'age' => '十八'
    ]
];
$validator = new  LValidator($data);
$validator->rules([
    ['required', 'demo.name'],//$data['demo']['name']必传
    ['integer', 'demo.age'],//$data['demo']['age']必须是整数
]);
if ($validator->validate()) {
    //验证成功
} else {
    var_dump($validator->errors());
}
```
输出
```
array (size=2)
  'demo.name' => 
    array (size=1)
      0 => string 'Demo.name不能为空' (length=21)
  'demo.age' => 
    array (size=1)
      0 => string 'Demo.age只能是整数(0-9)' (length=28)
```

##以下是支持的验证规则
* required     必传
* alpha        只能包括英文字母(a-z)
* alphaNum     只能包括英文字母(a-z)和数字(0-9)
* slug         只能包括英文字母(a-z)、数字(0-9)、破折号和下划线
* bool         只能是true或false
* contains     必须包含指定字符串
* compare      对比验证
* length       字符串长度对比验证(基于compare验证)
* date         只能是日期格式
* dateAfter    日期必须在指定日期之后
* dateBefore   日期必须在指定日期之前
* same         必须和指定字段值相同
* different    必须和指定字段值不同
* in           必须在指定范围
* notIn        必须不在指定范围
* integer      必须是整数
* numeric      必须是数字
* ip           必须是IP地址
* url          必须是URL地址
* tel          验证大陆电话
* carPlate     验证车牌号
* bankCard     验证银行卡号
* length       字符长度验证
* regex        匹配指定正则表达式
* func         使用函数或方法验证
* closure      使用闭包验证
* json         验证json格式

##验证规则使用Demo
- required(验证必传)
```
$validator->rule(['required', 'name']);
```
- alpha(验证英文字母)
```
$validator->rule(['alpha', 'name']);
```
- alphaNum(验证英文字母+数字)
```
$validator->rule(['alphaNum', 'name']);
```
- slug(英文字母+数字+破折号+下划线)
```
$validator->rule(['slug', 'name']);
```
- bool(验证布尔值)
```
$validator->rule(['bool', 'flag']);
```
- integer(验证整数)
```
$validator->rule(['integer', 'age']);
```
- numeric(数字)
```
$validator->rule(['numeric', 'money']);
```
- ip(验证IP地址)
```
$validator->rule(['ip', 'address']);
```
- ip(验证URL)
```
$validator->rule(['url', 'remoteUrl']);
```
- compare(对比验证(支持> >= < <= == === != !===)
```
$validator->rules([
    ['compare', 'age', ">", 18],//age > 18
    ['compare', 'age', ">=", 18],//age >= 18
    ['compare', 'age', "<", 18],//age < 18
    ['compare', 'age', "<=", 18],//age <= 18
    ['compare', 'age', "==", 18],//age == 18
    ['compare', 'age', "===", 18],//age === 18
    ['compare', 'age', "!=", 18],//age != 18
    ['compare', 'age', "!==", 18],//age !== 18
]);
```
- length(字符串长度对比验证,基于compare验证)
```
$validator->rules([
    ['length', 'name', ">", 18],//name长度 > 18
    ['length', 'name', ">=", 18],//name长度 >= 18
    ['length', 'name', "<", 18],//name长度 < 18
    ['length', 'name', "<=", 18],//name长度 <= 18
    ['length', 'name', "==", 18],//name长度 == 18
    ['length', 'name', "===", 18],//name长度 === 18
    ['length', 'name', "!=", 18],//name长度 != 18
    ['length', 'name', "!==", 18],//name长度 !== 18
]);
```

- contains(必须包含acb)
```
$validator->rule(['contains', 'name', 'abc']);
```
- in(必须在范围[1,2,3])
```
$validator->rule(['in', 'age', [1, 2, 3]]);
```
- notIn(必须不在范围[1,2,3])
```
$validator->rule(['notIn', 'age', [1, 2, 3]]);
```
- regex(正则验证)
```
$validator->rule(['regex', 'name', '/^cqh.*/']);
```
- date(验证日期格式)
```
$validator->rule(['date', 'create_time']);
```
- dateBefore(create_time必须在2017-10-01之前)
```
$validator->rule(['dateBefore', 'create_time', '2017-10-01']);
```
- dateAfter(create_time必须在2017-10-01之后)

```
$validator->rule(['dateAfter', 'create_time', '2017-10-01']);

```
- func(函数或方法验证)
```
//指定is_array方法验证
$validator->rule(['func', 'name', 'is_array']);
//指定类\libs\Utils\Array的sMultidim方法验证
$validator->rule(['func', 'name', [\libs\Utils\Arrays::class, 'isMultidim']]);
```
- 闭包验证(验证名字必须是helloWorld)
```
$validator->rule([function ($field, $value) {
    return $value == 'helloWorld';
}, 'name']);
```



##错误消息格式
默认消息在rule/规则类的message方法,如rule/Email
{field}最终替换为字段键, {value}替换为字段值
```
<?php

namespace libs\Validate\rules;
use libs\Validate\LValidator;

/**
 * Class Email
 * @package libs\Validate\rules
 */
class Email extends Rule
{
    /**
     * @return string
     */
    public static function message()
    {
        return "{field}是无效邮箱, 非法值{value}";
    }

    /**
     * @param $field
     * @param $value
     * @param array $params
     * @param LValidator $validator
     * @return bool
     */
    public static function validate($field, $value, $params = [], LValidator $validator)
    {
        return filter_var($value, \FILTER_VALIDATE_EMAIL) !== false;
    }
}
```
##自定义错误消息
* 1.通过在rule规则中指定message字段
```
$validator->rule(['required', 'name', 'message'=>'{field}不能为空']);
```
* 2.调用rule后通过message方法添加
```
$validator->rule(['integer', 'age'])->message("{field}不是整数, 非法值{value}");
```

##设置字段标签
- 通过lables批量方法追加, 如果已经在值, 将覆盖旧值
```
$validator->labels([
    'email' => '邮箱地址',
    'alphaTest' => '数字测试',
    'boolTest' => '布尔测试',
]);
```
- 调用rule后通过label方法添加
```
$validator->rule(['required', 'testRequired2'])->message("{field}不能为空(自定义格式)")->label('自定义标签testRequired2');

```


















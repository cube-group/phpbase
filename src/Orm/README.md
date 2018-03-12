## LDB是对pdo_mysql扩展(\PDO类)的高级封装
### 单库Demo
```
$db = LDB::create([
    'host' => '127.0.0.1',
    'port' => 3306,
    'username' => 'root',
    'password' => '*****',
    'database' => 'task',
    'prefix' => ''
]);

$result = $db->table('list')->select();
var_dump($result);
$this->printSQL($db->lastSql(), $db->lastError());
```
### 主从库Demo
```
$options = [
   'host' => '127.0.0.1',
   'port' => 3306,
   'username' => 'root',
   'password' => '*****',
   'database' => 'task',
   'prefix' => ''
];
$optionsSlave = [
   'host' => '127.0.0.1',
   'port' => 3307,
   'username' => 'root',
   'password' => '*****',
   'database' => 'task',
   'prefix' => ''
];
$db = LDB::create($options,$optionsSlave);

//使用了从库
$result = $db->table('list')->select();

//使用了主库
$result = $db->table('list')->where('a=1')->delete();
```
### LDB核心方法
* create - (静态方法)工厂模式生成Mysql连接
* table - 获取LDBModel实例
* exec - 执行sql用于insert、update、delete
* query - 执行sql用于select
* column - 执行sql用于计算sum、count
* commit - 如果table为事务,该方法则会commit
* lastSql - 最近一次执行的sql语句
* lastInsertId - 最近一次insert的id
* lastError - 最近一次执行sql的error
### 条件方法
* where - where语句,<br>
例如: where('a=1 AND b=2')或者where('a="hello" OR a="world"')
* order - order by语句,<br>
例如: where('column desc')或者where(['column1 desc','column2 asc'])
* limit - limit 语句,<br>
例如: limit(0,10)
* join - join语句,<br>
例如: join('table2 AS T2')
* on - join存在时的on语句,<br>
例如: table('table1 AS T1')->join('table2 AS T2')->on('T1.id=T2.tid')->select();
* group - group by语句,<br>
例如: group('status')或者group(['status','xxx'])
### 结果方法
* count - 获得数量,<br>
例如: count()或count('id')
* sum - 获得和,<br>
例如: sum('abc')
* one - select一条,<br>
例如: $db->table('table')->where('a=1')->one()
* select - select一条(或多条),<br>
例如: $db->table('table')->where('a=1')->select();或select('column')或select(['c1','c2'])
* update - 更新<br>
例如: $db->table('table')->where('a=1')->update(['column'=>'value'])
* insert - 插入<br>
例如: $db->table('table')->insert(['column1'=>'value1','column2'=>'value2'])
* insertMulti - 插入多条<br>
例如: $db->table('table')->insertMulti(['column1','column2'],[['value11','value12'],['value21','value22']])
* delete - 删除<br>
例如: $db->table('table')->where('a=1')->delete()
### 事务操作.
```
$db = LDB::create([
    'host' => '127.0.0.1',
    'port' => 3306,
    'username' => 'root',
    'password' => '*****',
    'database' => 'task',
    'prefix' => ''
]);

$db->beginTransaction();

$result = $db->table('list')->where(['a'=>1])->update(['b'=>2]);
$result = $db->table('list')->insert(['b'=>2]);
$result = $db->table('list')->insert(['b'=>3]);

$result = $db->commit();
var_dump($result);
```





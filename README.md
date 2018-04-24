# PHP开发工具包
### PHP版本要求
* 大于等于 PHP5.6
### 适用PHP框架
* Yaf、YII2、Laravel
### 相关pecl
* curl(5.6自带)
* pdo_mysql(5.6自带)
* gd(5.6自带)
* redis(pecl)
* mongo(pecl)
* memcached(pecl)
* amqp(pecl)
### 安装扩展
Mac OS X,推荐homebrew进行安装,举例如下:
```
brew install php56-redis
```
CentOS 6或7,推荐yum进行安装,举例如下:
```
yum -y install php-redis php-mongo
```
Linux下编译安装,以安装rabbitMQ扩展为例如下:
```
wget http://pecl.php.net/get/amqp-1.6.1.tgz
tar zxvf amqp-1.6.1.tgz
cd amqp-1.6.1
/usr/local/php/bin/phpize
./configure --with-php-config=/usr/local/php/bin/php-config --with-amqp --with-librabbitmq-dir=/usr/local/rabbitmq-c
make
make install
```
### 基础类库目录src
* Auth-基础验证器
* Cache-实现了redis(memcached)缓存操作
* Cdn-实现了文件upload/move/copy/del操作
* Crypt-字符串加解密
* Curl-实现了http的get和post请求
* File-实现了部分文件处理、文件上传、Excel处理、Pdf处理
* Image-实现了图片基础操作和验证码功能
* Log-实现了简单的本地日志功能
* Mail-实现了邮件发送和统一邮件发送功能
* Mongo-对于mongodb的简单封装
* Orm-对PDO进行了封装实现了orm功能
* Qrcode-二维码工具类库
* Queue-依靠Redis或RabbitMQ封装的队列
* Session-支持本地LSession和LRedisSession
* Utils-工具类
### autoload.php的使用
```
use libs\Curl\LCurl;
require __DIR__ . '/../src/autoload.php';
$curl = new LCurl();
$result = $curl->post('http://www.baidu.com/', ['a'=>'123']);
```
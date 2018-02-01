# PHP标准类库
### PHP版本要求
>= PHP5.6
### 适用PHP框架
Yaf、YII2、Laravel
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
### 基础类库目录libs
* Cache-实现了redis(memcached)缓存操作
* Cdn-实现了文件upload/move/copy/del操作
* Curl-实现了http的get和post请求
* Excel-实现了excel文件的解析和生成
* File-实现了部分文件处理和文件上传的封装
* Image-实现了图片基础操作和二维码功能
* Log-实现了简单的本地日志功能
* Mail-实现了邮件发送和统一邮件发送功能
* Mongo-对于mongodb的简单封装
* Orm-对PDO进行了封装实现了orm功能
* Qrcode-二维码工具类库
* Queue-依靠Redis或RabbitMQ封装的队列
* Service-简单的服务封装(包括:短信发送、推送)
* Session-支持本地LSession和LRedisSession
* Sync-同步业务的好帮手
* LValidator-简单优雅可扩展的验证类(实现常用验证:必传,邮箱,IP,URL,正则等)
### autoload.php的使用
```
use libs\Curl\LCurl;
require __DIR__ . '/../libs/autoload.php';
$curl = new LCurl();
$result = $curl->post('http://www.baidu.com/', ['a'=>'123']);
```
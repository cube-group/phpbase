## 对七牛CDN SDK进行了封装
### Demo
```
<?php

require __DIR__ . '/../libs/autoload.php';

use libs\Cdn\LCdn;

class TestLCdn
{
    private $cdn;

    public function __construct()
    {
        $AK = '9c7cob-LRsfL-oZPy6U2z6AvEESaVRBjtUP2gDJd';
        $SK = '8Xkp_3AKgNQkh7gdh4PqTCP7FA-npzWfIBQOQI9G';

        $this->cdn = new LCdn($AK, $SK, 'public.fuyoukache.com', 'http');
    }

    public function upload()
    {
        $localFile = __DIR__ . '/image/php.jpg';
        $bucket = 'public';

        $url = $this->cdn->upload($bucket, $localFile, 'test');
        var_dump($url);
    }

    /**
     * 获取账户所有空间
     */
    public function buckets()
    {
        $result = $this->cdn->buckets();
        var_dump($result);
    }

    /**
     * 获取资源信息
     */
    public function getResourceStat()
    {
        $bucket = 'public';
        $key = 'test/58c76afc07f8f-php.jpg';

        $result = $this->cdn->getResourceStat($bucket, $key);
        var_dump($result);
    }

    public function getResourceList()
    {
        $bucket = 'public';
        $prefix = 'test';

        $result = $this->cdn->getResourceList($bucket, $prefix, null, 2);
        var_dump($result);
    }


    public function delete()
    {
        $bucket = 'public';
        $key = 'test/58c76afc07f8f-php.jpg';

        $result = $this->cdn->delete($bucket, $key);
        var_dump($result);
    }

    public function update()
    {
        $bucket = 'public';
        $key = 'test/58c76afc07f8f-php.jpg';
        $localFile = __DIR__ . '/image/ico.jpg';

        $result = $this->cdn->update($bucket, $key, $localFile);
        var_dump($result);
    }
}

$c = new TestLCdn();
//$c->upload();
//$c->delete();
//$c->buckets();
//$c->getResourceStat();
$c->getResourceList();
//$c->update();
```
### 常用方法
* upload - 上传文件
* update - 更新文件
* move - 移动文件
* copy - 复制文件
* getResourceStat - 获取文件资源信息
* getResourceList - 获取文件列表

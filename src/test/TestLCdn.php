<?php

require __DIR__ . '/../libs/autoload.php';

use libs\Cdn\LCdn;
use libs\Service\LSConfig;

class TestLCdn
{
    private $cdn;

    public function __construct()
    {
        define('APP_MODE', 'prod');

        $cdnConfig = LSConfig::get()->cdn;
        $this->cdn = new LCdn(
            $cdnConfig->access,
            $cdnConfig->secret,
            $cdnConfig->domain,
            $cdnConfig->protocol
        );
    }

    public function upload()
    {
        $localFile = __DIR__ . '/image/php.jpg';
        $bucket = LSConfig::get()->cdn->bucket;

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
        $bucket = LSConfig::get()->cdn->bucket;
        $key = 'test/58c76afc07f8f-php.jpg';

        $result = $this->cdn->getResourceStat($bucket, $key);
        var_dump($result);
    }

    public function getResourceList()
    {
        $bucket = LSConfig::get()->cdn->bucket;
        $prefix = 'test';

        $result = $this->cdn->getResourceList($bucket, $prefix, null, 2);
        var_dump($result);
    }


    public function delete()
    {
        $bucket = LSConfig::get()->cdn->bucket;
        $key = 'test/58c76afc07f8f-php.jpg';

        $result = $this->cdn->delete($bucket, $key);
        var_dump($result);
    }

    public function update()
    {
        $bucket = LSConfig::get()->cdn->bucket;
        $key = 'test/58c76afc07f8f-php.jpg';
        $localFile = __DIR__ . '/image/ico.jpg';

        $result = $this->cdn->update($bucket, $key, $localFile);
        var_dump($result);
    }
}

$c = new TestLCdn();
$c->upload();
//$c->delete();
//$c->buckets();
//$c->getResourceStat();
//$c->getResourceList();
//$c->update();
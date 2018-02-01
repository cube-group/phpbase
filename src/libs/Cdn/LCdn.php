<?php
namespace libs\Cdn;

require __DIR__ . '/../../vendor/Qiniu/autoload.php';

use libs\Curl\LCurl;
use libs\File\LFile;
use libs\Service\Basic\LSResult;
use \Qiniu\Auth;
use \Qiniu\Storage\BucketManager;
use \Qiniu\Storage\UploadManager;
use \Exception;

/**
 * Class LCdn.
 * 使用七牛SDK完成相关操作.
 * @package libs\Cdn
 */
class LCdn extends LSResult
{
    /**
     * Auth Access Key.
     * @var string
     */
    private $accessKey = '';
    /**
     * Auth Secret Key
     * @var string
     */
    private $secretKey = '';
    /**
     * http/https
     * @var string
     */
    private $protocol = '';
    /**
     * 域名称.
     * @var string
     */
    private $domain = '';
    /**
     * @var Auth
     */
    private $auth;

    /**
     * LCdn constructor.
     * @param $accessKey string
     * @param $secretKey string
     * @param $domain string
     * @param string $protocol
     */
    public function __construct($accessKey, $secretKey, $domain, $protocol = 'http')
    {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
        $this->protocol = $protocol;
        $this->domain = $domain;
    }

    /**
     * 初始化认证验证.
     */
    private function initAuth()
    {
        $this->lastError = '';
        if (!$this->auth) {
            $this->auth = new Auth($this->accessKey, $this->secretKey);
        }
    }

    /**
     * 获取key所在bucket空间的绝对url地址.
     * @param $bucket
     * @param $key
     * @return string
     */
    private function getAbsoluteURL($bucket, $key)
    {
        return $this->protocol . '://' . $this->domain . '/' . $key;
    }

    /**
     * 本地文件上传.
     * @param $bucket string 七牛存储空间名称
     * @param $localFile string 本地文件路径
     * @param string $prefix 前缀
     * @param string $key 代替当前文件名称
     * @param $autoDelete bool 文件localFile上传完之后是否会被自动删除
     * @param $retry int 文件上传失败时的重试次数
     * @return bool|string
     */
    public function upload($bucket, $localFile, $prefix = '', $key = '', $autoDelete = true, $retry = 3)
    {
        if (!$bucket || !$localFile || !is_file($localFile)) {
            self::setResult(__FUNCTION__, 'params error', ['bucket' => $bucket, 'localFile' => $localFile, 'prefix' => $prefix, 'key' => $key, 'autoDelete' => $autoDelete]);
            return false;
        }
        if (!$key) {
            $key = uniqid() . '-' . basename($localFile);
        }
        if (substr($prefix, -1) == '/') {
            $prefix = substr($prefix, 0, -1);
        }
        $key = $prefix ? ($prefix . '/' . $key) : $key;
        try {
            $this->initAuth();
            $token = $this->auth->uploadToken($bucket);
            $uploadMgr = new UploadManager();
            $retryIndex = 0;
            while ($retryIndex < $retry) {
                $retryIndex++;
                list($ret, $err) = $uploadMgr->putFile($token, $key, $localFile);
                if ($err) {
                    self::setResult(__FUNCTION__, @$err->url(), ['retry' => $retryIndex, 'message' => @$err->message()]);
                } else {
                    if ($autoDelete) {
                        LFile::remove($localFile);
                    }
                    return $this->getAbsoluteURL($bucket, $key);
                }
            }
        } catch (Exception $e) {
            self::setResult(__FUNCTION__, '[catch error]', $e->getTraceAsString());
        }
        return false;
    }

    /**
     * 更新某个文件.
     * @param $bucket
     * @param $key
     * @param $localFile
     * @return bool
     */
    public function update($bucket, $key, $localFile)
    {
        if (!$localFile || !$bucket || !$key) {
            self::setResult(__FUNCTION__, 'params error', ['bucket' => $bucket, 'key' => $key, 'localFile' => $localFile]);
            return false;
        }
        if ($this->delete($bucket, $key)) {
            if ($url = $this->upload($bucket, $localFile, '', $key)) {
                $this->refreshFile($url);
                return true;
            }
        }
        return false;
    }


    /**
     * 重命名文件.
     * @param $bucket
     * @param $key
     * @param $desKey
     * @return bool
     */
    public function rename($bucket, $key, $desKey)
    {
        if (!$bucket || !$key || !$desKey) {
            self::setResult(__FUNCTION__, 'params error', ['bucket' => $bucket, 'key' => $key, 'desKey' => $desKey]);
            return false;
        }
        $this->initAuth();

        try {
            $bucketMgr = new BucketManager($this->auth);
            if ($err = $bucketMgr->rename($bucket, $key, $desKey)) {
                self::setResult(__FUNCTION__, @$err->url(), @$err->message());
            } else {
                return true;
            }
        } catch (Exception $e) {
            self::setResult(__FUNCTION__, '[catch error]', @$e->getTraceAsString());
        }
        return false;
    }

    /**
     * 移动cdn文件从空间$bucket到$desBucket
     * @param $bucket
     * @param $key
     * @param $desBucket
     * @param $desKey
     * @return string
     */
    public function move($bucket, $key, $desBucket, $desKey)
    {
        if (!$bucket || !$key || !$desBucket || !$desKey) {
            self::setResult(__FUNCTION__, 'params error', ['bucket' => $bucket, 'key' => $key, 'desBucket' => $desBucket, 'desKey' => $desKey]);
            return false;
        }
        $this->initAuth();

        try {
            $bucketMgr = new BucketManager($this->auth);
            if ($err = $bucketMgr->move($bucket, $key, $desBucket, $desKey)) {
                self::setResult(__FUNCTION__, @$err->url(), @$err->message());
            } else {
                return true;
            }
        } catch (Exception $e) {
            self::setResult(__FUNCTION__, '[catch error]', @$e->getTraceAsString());
        }
        return false;
    }

    /**
     * 复制cdn文件从空间$bucket到$desBucket
     * @param $bucket
     * @param $key
     * @param $desBucket
     * @param $desKey
     * @return string
     */
    public function copy($bucket, $key, $desBucket, $desKey)
    {
        if (!$bucket || !$key || !$desBucket || !$desKey) {
            self::setResult(__FUNCTION__, 'params error', ['bucket' => $bucket, 'key' => $key, 'desBucket' => $desBucket, 'desKey' => $desKey]);
            return false;
        }
        $this->initAuth();

        try {
            $bucketMgr = new BucketManager($this->auth);
            if ($err = $bucketMgr->copy($bucket, $key, $desBucket, $desKey)) {
                self::setResult(__FUNCTION__, @$err->url(), @$err->message());
            } else {
                return true;
            }
        } catch (Exception $e) {
            self::setResult(__FUNCTION__, '[catch error]', @$e->getTraceAsString());
        }
        return false;
    }


    /**
     * 移出文件.
     * @param $bucket
     * @param $key
     * @return bool
     */
    public function delete($bucket, $key)
    {
        if (!$bucket || !$key) {
            self::setResult(__FUNCTION__, 'params error', ['bucket' => $bucket, 'key' => $key]);
            return false;
        }
        $this->initAuth();

        try {
            $bucketMgr = new BucketManager($this->auth);
            if ($err = $bucketMgr->delete($bucket, $key)) {
                self::setResult(__FUNCTION__, @$err->url(), @$err->message());
            } else {
                return true;
            }
        } catch (Exception $e) {
            self::setResult(__FUNCTION__, '[catch error]', @$e->getTraceAsString());
        }
        return false;
    }


    /**
     * 获取账户空间列表.
     * @return bool|\string[]
     */
    public function buckets()
    {
        $this->initAuth();
        try {
            $bucketMgr = new BucketManager($this->auth);
            if ($result = $bucketMgr->buckets()) {
                list($rt, $err) = $result;
                if ($err) {
                    self::setResult(__FUNCTION__, @$err->url(), @$err->message());
                } else {
                    return $rt;
                }
            }
        } catch (Exception $e) {
            self::setResult(__FUNCTION__, '[catch error]', @$e->getTraceAsString());
        }
        return false;
    }


    /**
     * 获取空间中资源的信息.
     * @param $bucket string
     * @param $key string 包含前缀的文件名
     * @return array|bool
     */
    public function getResourceStat($bucket, $key)
    {
        $this->initAuth();
        try {
            $bucketMgr = new BucketManager($this->auth);
            if ($result = $bucketMgr->stat($bucket, $key)) {
                list($rt, $err) = $result;
                if ($err) {
                    self::setResult(__FUNCTION__, @$err->url(), @$err->message());
                } else {
                    return $rt;
                }
            }
        } catch (Exception $e) {
            self::setResult(__FUNCTION__, '[catch error]', @$e->getTraceAsString());
        }
        return false;
    }

    /**
     * 资源列举.
     * @param $bucket
     * @param $prefix
     * @param $marker string
     * @param int $limit
     * @return array|bool
     */
    public function getResourceList($bucket, $prefix, $marker, $limit = 100)
    {
        $this->initAuth();
        try {
            $bucketMgr = new BucketManager($this->auth);
            if ($result = $bucketMgr->listFiles($bucket, $prefix, $marker, $limit)) {
                list($list, $newMaker, $err) = $result;
                if ($err) {
                    self::setResult(__FUNCTION__, @$err->url(), @$err->message());
                } else {
                    return ['list' => $list, 'marker' => $newMaker ? $newMaker : ''];
                }
            }
        } catch (Exception $e) {
            self::setResult(__FUNCTION__, '[catch error]', @$e->getTraceAsString());
        }
        return false;
    }

    /**
     * 刷新文件缓存.
     * @param $value string 七牛空间内的url链接
     * @return bool
     */
    public function refreshFile($value)
    {
        $this->initAuth();
        $url = "http://fusion.qiniuapi.com/refresh";
        $token = $this->auth->signRequest($url, null);
        $curl = new LCurl(LCurl::POST_JSON);
        $curl->post($url, ['urls' => [$value]], ['Authorization: QBox ' . $token]);
        return true;
    }
}
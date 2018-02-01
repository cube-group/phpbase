## LQrcode是php生成二维码初级封装库
### Demo
```
<?php

use libs\Qrcode\LQrcode;

require __DIR__ . '/../libs/autoload.php';

/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/3/24
 * Time: 上午11:55
 */
class TestLQrcode
{
    private $text = 'Hello World!';

    public function displayPng()
    {
        LQrcode::png($this->text, false);
    }

    public function savePng()
    {
        $outFile = __DIR__ . '/image/qrcode.png';
        LQrcode::png($this->text, $outFile);
    }

    public function displayText()
    {
        var_dump(LQrcode::text($this->text));
    }

    public function saveText()
    {
        $outFile = __DIR__ . '/image/qrcode.text';
        LQrcode::text($this->text, $outFile);
    }

    public function savePngWaterMark()
    {
        $waterFile = __DIR__ . '/image/water.jpg';
        $outFile = __DIR__ . '/image/qrcode-with-water.png';
        var_dump(LQrcode::pngWithWaterMark($this->text, $waterFile, $outFile));
    }

    public function displayPngWaterMark()
    {
        $waterFile = __DIR__ . '/image/water.jpg';
        LQrcode::pngWithWaterMark($this->text, $waterFile);
    }
}

$qr = new TestLQrcode();
//$qr->displayPng();
//$qr->savePng();
//$qr->displayText();
//$qr->saveText();
//$qr->savePngWaterMark();
$qr->displayPngWaterMark();
```
### 相关函数
* 默认生成108*108大小的二维码图片;
* LQrcode::png('http://www.google.com/');
* LQrcode::text('http://www.google.com/');用于前端生成svg或者canvas
* LQrcode::pngWithWaterMark('http://www.google.com/','/var/water.png');
用于生成带有水印的二维码图片
* 注意,如果没有标识目标存储图片地址,则会直接http下载
<?php

require __DIR__ . '/../src/autoload.php';

use \libs\Image\LImage;

class TestLImage
{
    private $file = __DIR__ . '/image/php.jpg';
    private $waterMarkFile = __DIR__ . '/image/water.png';

    //下载验证码.
    public function downloadCaptcha()
    {
        LImage::downloadCaptcha('A3B2CD', 100, 32, 100);
    }

    //获取jpeg源数据.
    public function getCaptcha()
    {
        header('Content-Type: image/jpg');
//        LImage::setCaptchaTextColor([51, 51, 51]);
        echo LImage::getCaptchaData('123456', 210, 80, 100);
    }

    //保存验证码
    public function saveCaptcha()
    {
        $desFile = __DIR__ . '/image/save.jpeg';
        LImage::saveCaptcha('A44444', $desFile, 100, 32, 100);
    }

    //给图片加水印.
    public function waterMark()
    {
        $desFile = __DIR__ . '/image/new-water.jpg';
        LImage::waterMarkImage($this->file, $this->waterMarkFile, false, 10, 10, 25, 25);
    }

    /**
     * 改变图片尺寸
     */
    public function resizeImage()
    {
        $desFile = __DIR__ . '/image/new-resize.jpeg';
        var_dump(LImage::resizeImage($this->file, 100, 100, $desFile));
    }

    /**
     * 旋转图片
     */
    public function rotateImage()
    {
        $desFile = __DIR__ . '/image/new-rotate.jpeg';
        var_dump(LImage::rotateImage($this->file, 90, $desFile));
    }

    public function image2Gif()
    {
        var_dump(LImage::image2Gif($this->file));
    }

    public function image2Png()
    {
        var_dump(LImage::image2Png($this->file));
    }
}

$image = new TestLImage();
//$image->saveCaptcha();
//$image->downloadCaptcha();
$image->getCaptcha();
//$image->waterMark();
//$image->resizeImage();
//$image->rotateImage();
//$image->image2Gif();
//$image->image2Png();
<?php

use libs\Qrcode\LQrcode;

require __DIR__ . '/../src/autoload.php';

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
        LQrcode::png($this->text);
    }

    public function savePng()
    {
        $outFile = __DIR__ . '/image/qrcode.png';
        var_dump(LQrcode::png($this->text, $outFile));
    }

    public function savePngWaterMark()
    {
        $waterFile = __DIR__ . '/image/water.jpg';
        $outFile = __DIR__ . '/image/qrcode-with-water.png';
        var_dump(LQrcode::pngWithWaterMark($this->text, $waterFile, $outFile));
    }

    public function displayPngWaterMark()
    {
        $waterFile = __DIR__ . '/image/water1.jpg';
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
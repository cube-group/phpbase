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
$qr->displayPng();
//$qr->savePng();
//$qr->displayText();
//$qr->saveText();
//$qr->savePngWaterMark();
//$qr->displayPngWaterMark();
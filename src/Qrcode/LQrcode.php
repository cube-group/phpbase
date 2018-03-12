<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/3/24
 * Time: 上午11:26
 */

namespace libs\Qrcode;

use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;
use libs\Image\LImage;
use libs\Utils\ContentType;
use PhpOffice\PhpSpreadsheet\Exception;

/**
 * Class LQrcode.
 * 二维码封装工具库.
 * @package libs\Qrcode
 */
class LQrcode
{
    /**
     * 生成png二维码.
     * @param $text string 文字内容
     * @param $filename string 文件名称
     * @param $width int
     * @param $height int
     * @param $margin int
     * @return mixed
     */
    public static function png($text, $filename = '', $width = 256, $height = 256, $margin = 1)
    {
        $sourceFile = $filename ? $filename : (sys_get_temp_dir() . '/' . uniqid() . '.png');
        $renderer = new Png();
        $renderer->setHeight($width);
        $renderer->setWidth($height);
        $renderer->setMargin($margin);
        $writer = new Writer($renderer);
        try {
            $writer->writeFile($text, $sourceFile);
        } catch (Exception $e) {
            echo "";
            return false;
        }

        if ($filename) {
            return $filename;
        }

        @header('Content-Type: image/png');
        @readfile($sourceFile);
        return true;
    }


    /**
     * 生成带有水印的二维码
     * @param $text
     * @param $waterFile
     * @param $outFile
     * @param int $width
     * @param int $height
     * @return bool
     */
    public static function pngWithWaterMark($text, $waterFile, $outFile = false, $width = 256, $height = 256, $margin = 1)
    {
        if (!is_file($waterFile)) {
            return false;
        }
        $sourceFile = $outFile ? $outFile : (sys_get_temp_dir() . '/' . uniqid() . '.png');
        $renderer = new Png();
        $renderer->setHeight($width);
        $renderer->setWidth($height);
        $renderer->setMargin($margin);
        $writer = new Writer($renderer);
        try {
            $writer->writeFile($text, $sourceFile);
        } catch (Exception $e) {
            echo "";
            return false;
        }

        if (!is_file($sourceFile)) {
            return false;
        }
        if(!$img = @imagecreatefromjpeg($waterFile)){
            return false;
        }
        $waterWidth = imagesx($img);
        $waterHeight = imagesy($img);

        $result = LImage::waterMarkImage(
            $sourceFile,
            $waterFile,
            $sourceFile,
            (int)(($width - $waterWidth) >> 1),
            (int)(($height - $waterHeight) >> 1),
            $waterWidth,
            $waterHeight
        );

        if (!$outFile) {
            header('Content-type: ' . ContentType::getFileContentType($sourceFile));
            readfile($sourceFile);
        }
        return $result;
    }
}
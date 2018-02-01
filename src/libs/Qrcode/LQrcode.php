<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/3/24
 * Time: 上午11:26
 */

namespace libs\Qrcode;

use libs\Image\LImage;
use libs\Utils\ContentType;
use QRcode;

require __DIR__ . '/../../vendor/Qrcode/full/qrlib.php';

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
     * @param $outFile bool|string 要存储的文件地址
     * @param int $level 处理等级
     * @param int $size 大小等级
     * @param int $margin 边距
     * @return mixed
     */
    public static function png($text, $outFile = false, $level = 2, $size = 4, $margin = 1)
    {
//        $m46 = [1,2,1];//46*46
//        $m54 = [2,2,1];//54*54
//        $m81 = [2,3,1];//81*81
//        $m108 = [2,4,1];//108*108
//        $m135 = [3,5,1];//135*135
//        $m216 = [3,8,1];//216*216
//        $m270 = [3,10,1];//270*270
        QRcode::png($text, $outFile, $level, $size, $margin);
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
    public static function pngWithWaterMark($text, $waterFile, $outFile = false, $width = 25, $height = 25)
    {
//        $m108 = [2,4,1];//108*108
        if (!is_file($waterFile)) {
            return false;
        }
        $sourceFile = $outFile ? $outFile : (sys_get_temp_dir() . '/' . uniqid() . '.jpg');
        QRcode::png($text, $sourceFile, 2, 4, 1);
        if (!is_file($sourceFile)) {
            return false;
        }
        $img = imagecreatefrompng($sourceFile);
        if (!$img) {
            return false;
        }
        $bgWidth = imagesx($img);
        $bgHeight = imagesy($img);

        $result = LImage::waterMarkImage(
            $sourceFile,
            $waterFile,
            $sourceFile,
            (int)(($bgWidth - $width) >> 1),
            (int)(($bgHeight - $height) >> 1),
            $width,
            $height
        );

        if (!$outFile) {
            header('Content-type: ' . ContentType::getFileContentType($sourceFile));
            readfile($sourceFile);
        }
        return $result;
    }


    /**
     * 生成二维队列字符串
     * @param $text
     * @param bool $outFile
     * @param int $level
     * @param int $size
     * @param int $margin
     * @return mixed
     */
    public static function text($text, $outFile = false, $level = 2, $size = 4, $margin = 1)
    {
//        $m46 = [1,2,1];//46*46
//        $m54 = [2,2,1];//54*54
//        $m81 = [2,3,1];//81*81
//        $m108 = [2,4,1];//108*108
//        $m135 = [3,5,1];//135*135
//        $m216 = [3,8,1];//216*216
//        $m270 = [3,10,1];//270*270
        if ($outFile) {
            QRcode::text($text, $outFile, $level, $size, $margin);
        }
        return QRcode::text($text, false, $level, $size, $margin);
    }
}
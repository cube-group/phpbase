<?php

use libs\File\LPdf;

require __DIR__ . '/../src/autoload.php';

class TestLFile
{
    /**
     * html生成在线pdf
     */
    public function outputOnline()
    {
        header('application/pdf');
        LPdf::outputOnline('<p>hello world</p>');
    }

    /**
     * html生成本地pdf文件
     */
    public function outputFile()
    {
        $r = LPdf::outputFile('<p>hello world</p>', __DIR__ . '/aaa.pdf');
        var_dump($r);
    }
}

$t = new TestLFile();
$t->outputFile();
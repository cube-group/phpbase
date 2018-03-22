<?php

use libs\File\LPdf;

require __DIR__ . '/../src/autoload.php';

class TestLFile
{
    /**
     * html生成在线pdf
     */
    public function outputPdfOnline()
    {
        header('application/pdf');
        LPdf::outputOnline('<p>hello world</p>');
    }

    /**
     * html生成本地pdf文件
     */
    public function outputPdfFile()
    {
        $r = LPdf::outputFile('<p>hello world</p>', __DIR__ . '/aaa.pdf');
        var_dump($r);
    }

    public function outputPdfContainsImageOnline()
    {
        header('application/pdf');
        LPdf::outputOnline('<div>
<p>hello world</p>
<div>
<img src="/test/image/php.jpg"/>
</div>
</div>');
    }
}

$t = new TestLFile();
//$t->outputPdfFile();
$t->outputPdfContainsImageOnline();
<?php

use libs\Excel\LExcel;

require __DIR__ . '/../libs/autoload.php';

/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/7/27
 * Time: 下午6:19
 */
class TestLExcel
{
    public function __destruct()
    {
        $datas = [];
        for ($i = 0; $i < 3; $i++) {
            $item = [];
            for ($j = 0; $j < 100; $j++) {
                $item[] = '列' . $j;
            }
            $datas[] = $item;
        }
        var_dump($datas);
        LExcel::create(__FILE__ . '/a.excel', $datas);
    }
}

$t = new TestLExcel();
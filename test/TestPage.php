<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 2018/4/24
 * Time: 上午9:08
 */
require __DIR__ . '/../src/autoload.php';

$page = \libs\Utils\PageUtil::create(1, 10, 10, ['uid' => 3]);
echo $page->getPagination('/index');
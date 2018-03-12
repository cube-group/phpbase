<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/3/8
 * Time: 下午4:07
 */
use libs\Mail\LMail;

require __DIR__ . '/../src/autoload.php';

function send()
{
    $mail = new LMail([
        'host' => 'smtp.qq.com',
        'port' => 465,
        'username' => '329483466@qq.com',
        'password' => 'guvbucedlqghcbbb',
        'encryption' => 'ssl'
    ]);

    $result = $mail->send(
        'title',
        '<p>asdfa</p>',
        'linyang',
        ['linyangflash@163.com', 'lin2798003@sina.com'],
        [
            ['filename' => __DIR__ . '/image/water.jpg', 'contentType' => 'image/jpeg', 'name' => '图片.jpg'],
            ['filename' => __DIR__ . '/image/water.jpg', 'contentType' => 'image/jpeg', 'name' => '图片.jpg']
        ]
    );
    var_dump($result);
}

send();
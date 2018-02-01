<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/3/8
 * Time: 下午4:07
 */
use libs\Mail\LMail;

require __DIR__ . '/../libs/autoload.php';

function send()
{
    $mail = new LMail([
        'host' => 'smtp.sina.com',
        'port' => 36,
        'username' => 'sss@sina.com',
        'password' => 'password'
    ]);

    $result = $mail->send('title', '<p>asdfa</p>', 'linyangflash@163.com', 'aaa@sina.com');
    var_dump($result);
}

send();
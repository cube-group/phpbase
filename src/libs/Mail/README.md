# LMail-简单邮件发送工具
### LMail的使用
```
use libs\Mail\LMail;
require 'autoloader.php';

function send()
{
    $mail = new LMail([
        'host' => 'smtp.xx.com',
        'port' => 36,
        'username' => 'from@xx.com',
        'password' => '******',
        'debug' => 0,
        'encryption' => 'ssl',
        'timeout' => 10
    ]);

    return $mail->send('title', '<p>html cotnent</p>', 'from@xx.com', 'receiver@xx.com');
}

var_dump(send());
```
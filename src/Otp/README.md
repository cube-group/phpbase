# OTP - One Time Password
* LOtp::now($secret); //return 6位验证码
* LOtp::verify($secret,$code);//return bool
* LOtp::getGoogleOtpAuthUrl($secret,$name);
/return 'otpauth://totp/name?secret=JBSWY3DPEHPK3PXP'
//用于生成二维码使用Google Authenticator

### Demo
```
<?php

use libs\Otp\LOtp;

require __DIR__ . '/../libs/autoload.php';

/**
 * Class TestLOtp
 */
class TestLOtp
{
    /**
     * TestLOtp constructor.
     */
    public function __construct()
    {
        $secret = 'fykc-third';

        var_dump(LOtp::getGoogleOtpAuthUrl($secret, 'linyang@foryou56.com'));
        var_dump(LOtp::now($secret));
        var_dump(LOtp::verify($secret, 666666));
    }
}

new TestLOtp();
```
### 重要用途用于密码加固
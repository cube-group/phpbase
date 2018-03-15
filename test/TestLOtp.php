<?php

use libs\Otp\LOtp;

require __DIR__ . '/../src/autoload.php';

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
        $secret = 'motherfucker';

        var_dump(LOtp::getGoogleOtpAuthUrl($secret, 'adfads'));
        var_dump(LOtp::now($secret));
        var_dump(LOtp::verify($secret, 671685));
    }
}

new TestLOtp();
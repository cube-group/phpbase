<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 17/3/8
 * Time: 下午3:53
 */

namespace libs\Mail;

use PHPMailer\PHPMailer;

require __DIR__ . '/../../vendor/PHPMailer/autoload.php';

/**
 * Class LMail
 * @package libs\Mail
 */
class LMail
{
    /**
     * @var PHPMailer
     */
    private $mail;
    /**
     * 发件人昵称.
     * @var string
     */
    private $nickName = '';

    /**
     * Mail constructor.
     * ['host'=>'stmp host','username'=>'sender mail','password'=>'*','port'=>20,'encryption'=>'ssl','debug'=>0,'timeout'=>5]
     * @param $options
     */
    public function __construct($options)
    {
        if (!$options) {
            $options = [];
        }

        $this->mail = new PHPMailer();
        $this->mail->SMTPDebug = isset($options['debug']) ? $options['debug'] : 0;          // Enable verbose debug output
        $this->mail->isSMTP();                                                          // Set mailer to use SMTP
        $this->mail->Host = $options['host'];                                           // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;                                                   // Enable SMTP authentication
        $this->mail->Username = $options['username'];                                   // SMTP username
        $this->mail->Password = $options['password'];                                   // SMTP password
        $this->mail->SMTPSecure = isset($options['encryption']) ? $options['encryption'] : 'tls';          // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = $options['port'];
        $this->mail->Timeout = isset($options['timeout']) ? $options['timeout'] : 10;
        $this->mail->isHTML(isset($options['html']) ? $options['html'] : true);                  // Set email format to HTML
        $this->nickName = isset($options['nick']) ? $options['nick'] : 'mailer';
    }


    /**
     * 发送邮件.
     * @param $subject
     * @param $html
     * @param $from
     * @param $receivers
     * @param null $attaches
     * @return bool
     * @throws \PHPMailer\RuntimeException
     */
    public function send($subject, $html, $from, $receivers, $attaches = null)
    {
        // TCP port to connect to

        $this->mail->setFrom($from, $this->nickName);

        // Add a recipient
        if (!is_array($receivers)) {
            $receivers = explode(',', $receivers);
            if (!$receivers) {
                return false;
            }
        }
        foreach ($receivers as $rec) {
            $this->mail->addAddress($rec);
        }

//        $this->mail->addAddress('ellen@example.com','joe');               // Add a recipient
//        $this->mail->addReplyTo('info@example.com', 'Information');
//        $this->mail->addCC('cc@example.com');
//        $this->mail->addBCC('bcc@example.com');

        // Add attachments
        if ($attaches) {
            if (!is_array($attaches)) {
                $attaches = [$attaches];
            }
            foreach ($attaches as $att) {
                $this->mail->addAttachment($att);
            }
        }

        $this->mail->CharSet = 'utf-8';
        $this->mail->Subject = $subject;
        $this->mail->msgHTML($html . '<br><br><br>'); //<br>是防止有附件导致错位
        $this->mail->AltBody = 'text/html';

        $result = $this->mail->send();
        $this->mail->clearAddresses();
        $this->mail->clearAllRecipients();
        $this->mail->clearAttachments();
        $this->mail->clearBCCs();
        $this->mail->clearCustomHeaders();
        $this->mail->clearCCs();
        $this->mail->clearReplyTos();

        return $result;
    }
}
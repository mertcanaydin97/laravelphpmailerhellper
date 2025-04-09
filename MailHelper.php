<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class MailHelper
{


    public static function sendMail($to, $subject, $content)
    {

        self::mailer($to, $subject, $content);

    }

    private static function mailer($reciver, $subject, $body)
    {
        $mail = new PHPMailer(true);
        try {
            /* Email SMTP Settings */

            $mail->SMTPDebug = 0;

            $mail->isSMTP();

            $mail->CharSet = "UTF-8";

            $mail->Host = env('MAIL_HOST');

            $mail->SMTPAuth = true;

            $mail->Username = env('MAIL_USERNAME');

            $mail->Password = env('MAIL_PASSWORD');

            $mail->SMTPSecure = env('MAIL_ENCRYPTION');

            $mail->Port = env('MAIL_PORT');

            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            $mail->addAddress($reciver);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = self::template($body);
            if (!$mail->send()) {

                return "error";

            } else {

                return "success";

            }



        } catch (Exception $e) {

            return "error";

        }
    }

    private static function template($body)
    {
        return '
<--begin:Email Header-->
<--end:Email Header-->
                            <!--begin:Email content-->
    ' . $body . '
    <!--end:Email content-->
<--begin:Email Footer-->
<--end:Email Footer-->
';
    }

}

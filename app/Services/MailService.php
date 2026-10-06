<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public static function sendMail($to, $toName, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // SMTP settings for your domain
            $mail->isSMTP();
            $mail->Host = 'mail.yousab-tech.com'; // Your domain's SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'admin@yousab-tech.com'; // Your domain email
            $mail->Password = 'cH7BoeT%Y6ve'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL or ENCRYPTION_STARTTLS for TLS
            $mail->Port = 465; // SSL port 465, or TLS port 587

            // Character encoding settings
            $mail->CharSet = 'UTF-8'; // Ensure UTF-8 encoding for subject and body

            // Email settings
            $mail->setFrom('admin@yousab-tech.com', 'Blanko Tech'); // From email and name
            $mail->addAddress($to, $toName); // Recipient's email and name

            $mail->isHTML(true); // Email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body; // HTML body content
            $mail->AltBody = strip_tags($body); // Plain text body content for non-HTML clients

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Log or return the error message for debugging
            return "Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

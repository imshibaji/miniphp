<?php
namespace Shibaji\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true); // Enable exceptions
        $this->initializeMailer();
    }

    protected function initializeMailer()
    {
        // Server settings
        $this->mailer->isSMTP(); // Set mailer to use SMTP
        $this->mailer->Host = 'smtp.example.com'; // Specify main and backup SMTP servers
        $this->mailer->SMTPAuth = true; // Enable SMTP authentication
        $this->mailer->Username = 'your-email@example.com'; // SMTP username
        $this->mailer->Password = 'your-password'; // SMTP password
        $this->mailer->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $this->mailer->Port = 587; // TCP port to connect to

        // Optional: Set default sender
        $this->mailer->setFrom('your-email@example.com', 'Your Name');
    }

    /**
     * Sends an email.
     *
     * @param string $to Recipient email address.
     * @param string $subject Email subject.
     * @param string $body Email body (supports HTML).
     * @param array $attachments Array of file paths for attachments (optional).
     * @return bool True if the email was sent successfully, false otherwise.
     */
    public function send($to, $subject, $body, $attachments = [])
    {
        try {
            // Recipients
            $this->mailer->addAddress($to); // Add a recipient

            // Content
            $this->mailer->isHTML(true); // Set email format to HTML
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            // Attachments
            foreach ($attachments as $attachment) {
                $this->mailer->addAttachment($attachment); // Add attachments
            }

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
            return false;
        }
    }
}

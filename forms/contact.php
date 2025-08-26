<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$receiving_email_address = 'ips.globalcall@gmail.com';

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    $from_name = htmlspecialchars($_POST['name']);
    $from_email = htmlspecialchars($_POST['email']);
    $service = isset($_POST['service']) ? htmlspecialchars($_POST['service']) : 'Non spécifié';
    $subject = $service; // on prend le service comme sujet
    $message = htmlspecialchars($_POST['message']);

    $smtp_host = 'smtp.mail.me.com';
    $smtp_username = 'fozetj29@icloud.com';
    $smtp_password = 'kkpr-yhkd-oxrj-qjqc';
    $smtp_port = 587;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtp_port;

        $mail->setFrom($smtp_username, 'Contact Form');
        $mail->addAddress($receiving_email_address);

        $mail->isHTML(true);
        $mail->Subject = 'Nouvelle demande: ' . $subject;

        $mail->Body = "
            <div><strong>Nom:</strong> {$from_name}</div>
            <div><strong>Email:</strong> {$from_email}</div>
            <div><strong>Service:</strong> {$service}</div>
            <div><strong>Message:</strong><br>" . nl2br($message) . "</div>";

        echo $mail->send() ? 'OK' : 'Mailer Error: ' . $mail->ErrorInfo;

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Form submission failed. Missing required fields.';
}
?>

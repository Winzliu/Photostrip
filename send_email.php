<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['imageData']) && isset($_POST['name']) && isset($_POST['email'])) {
    $imageData = $_POST['imageData'];
    $name = $_POST['name'] ?? 'Guest';
    $email = $_POST['email'] ?? '';
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $decodedImage = base64_decode($imageData);

    if ($decodedImage === false) {
        echo 'Error: Failed to decode image data.';
        exit;
    }

    $filename = 'photostrip_ClayMe_' . time() . '.png';
    $filepath = sys_get_temp_dir() . '/' . $filename;

    if (!file_put_contents($filepath, $decodedImage)) {
        echo 'Error: Failed to save image to file.';
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '[YourEmail]'; // Replace with your email
        $mail->Password = '[YourEmailPassword]'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('[YourEmail]', 'ClayMe!'); // Replace with your email
        $mail->addAddress($email, $name);

        $mail->addAttachment($filepath, $filename);

        $mail->isHTML(true);
        $mail->Subject = 'Your ClayMe! Photo Strip';
        $mail->Body = 'Hello,<br><br>Here is your photo strip from ClayMe! attached.<br><br>Enjoy!<br><br>Best regards,<br>The ClayMe! Team';
        $mail->AltBody = 'Hello, Here is your photo strip from ClayMe! attached. Enjoy! Best regards, The ClayMe! Team';

        $mail->send();
        echo 'Email sent successfully!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } finally {
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }

} else {
    echo 'Invalid request.';
}
?>
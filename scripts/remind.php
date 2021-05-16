<?php
$path = '../frameworks/php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../frameworks/php/PHPMailer/src/Exception.php';
require '../frameworks/php/PHPMailer/src/PHPMailer.php';
require '../frameworks/php/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'mail.poiseugm.net';
$mail->Port       = 465;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->SMTPAuth   = true;
$mail->Username   = 'notifikasi@poiseugm.net';
$mail->Password   = '({A=&=32~Kn;a@0$>?};9+I&W}?a\P';
$mail->SMTPKeepAlive = true;
$mail->setFrom('notifikasi@poiseugm.net', 'POISE UGM');
$mail->isHTML(true);
$mail->Subject = 'Notifikasi pendaftaran POISETalks';
$mail->Body = "Lmao";
$mail->addAttachment('./test.pdf', 'guide.pdf');

$username = "poiq2362_admin";
$passwd = "Su.}6U46?l%P";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $mysqli = new mysqli("127.0.0.1", "$username", "$passwd", "poiq2362_testing", 3306);
  $mysqli->set_charset("utf8mb4");
} catch(Exception $e) {
  error_log($e->getMessage());
}
$mysqli->set_charset("utf8mb4");
$result = mysqli_query($mysqli, 'SELECT name, email FROM webinart WHERE sent = FALSE');

foreach ($result as $row) {
    try {
        $mail->addAddress($row['email'], $row['name']);
    } catch (Exception $e) {
        echo 'Invalid address skipped: ' . htmlspecialchars($row['email']) . '<br>';
        continue;
    }

    try {
        $mail->send();
        echo 'Message sent to :' . htmlspecialchars($row['name']) . ' (' .
            htmlspecialchars($row['email']) . ')<br>';
        //Mark it as sent in the DB
        mysqli_query(
            $mysqli,
            "UPDATE webinart SET sent = TRUE WHERE email = '" . mysqli_real_escape_string($mysqli, $row['email']) . "'"
        );
    } catch (Exception $e) {
        echo 'Mailer Error (' . htmlspecialchars($row['email']) . ') ' . $mail->ErrorInfo . '<br>';
        //Reset the connection to abort sending this message
        //The loop will continue trying to send to the rest of the list
        $mail->getSMTPInstance()->reset();
    }
    //Clear all addresses and attachments for the next iteration
    $mail->clearAddresses();
    $mail->clearAttachments();
}
?>

<?php
$path = '../../frameworks/php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../frameworks/php/PHPMailer/src/Exception.php';
require '../../frameworks/php/PHPMailer/src/PHPMailer.php';
require '../../frameworks/php/PHPMailer/src/SMTP.php';
$dbconfirm = 0;
$upconfirm = 0;
$username = "poiq2362_admin";
$passwd = "Su.}6U46?l%P";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $mysqli = new mysqli("127.0.0.1", "$username", "$passwd", "poiq2362_form_dev", 3306);
  $mysqli->set_charset("utf8mb4");
  $dbconfirm = 1;
} catch(Exception $e) {
  error_log($e->getMessage());
  $dbconfirm = 0;
}
$mysqli->set_charset("utf8mb4");
$x = "";

if ($_POST['webinar1'] == 1) {
    $x .= "<li>POISETalks 1: FMCG</li>";
    $stmt = $mysqli->prepare("INSERT INTO webinar1 (name, email, dob, gender, phone, institution) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution']);
    $stmt->execute();
    $stmt->close();
}
if ($_POST['webinar2'] == 1) {
    $x .= "<li>POISETalks 2: Nickel Industry</li>";
    $stmt = $mysqli->prepare("INSERT INTO webinar2 (name, email, dob, gender, phone, institution) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution']);
    $stmt->execute();
    $stmt->close();
}
if ($_POST['webinar3'] == 1) {
    $x .= "<li>POISETalks 3: Renewable energy</li>";
    $stmt = $mysqli->prepare("INSERT INTO webinar3 (name, email, dob, gender, phone, institution) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution']);
    $stmt->execute();
    $stmt->close();
}
if ($_POST['webinar4'] == 1) {
    $x .= "<li>POISETalks 4: Diversity and Inclusion in Engineering</li>";
    $stmt = $mysqli->prepare("INSERT INTO webinar4 (name, email, dob, gender, phone, institution) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution']);
    $stmt->execute();
    $stmt->close();
}
if ($_POST['webinar5'] == 1) {
    $x .= "<li>POISETalks 5: Challenge in Sustainable Industry</li>";
    $stmt = $mysqli->prepare("INSERT INTO webinar5 (name, email, dob, gender, phone, institution) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution']);
    $stmt->execute();
    $stmt->close();
}
$uploaddir = '../../fileup/webinar/';
$uploadfile = $uploaddir . basename($_FILES['twib']['name']);
if (move_uploaded_file($_FILES['twib']['tmp_name'], $uploadfile)) {
    $upconfirm = 1;
} else {
    $upconfirm = 0;
}
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'mail.poiseugm.net';
$mail->SMTPAuth   = true;
$mail->Username   = 'notifikasi@poiseugm.net';
$mail->Password   = '({A=&=32~Kn;a@0$>?};9+I&W}?a\P';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = 465;
$mail->setFrom('notifikasi@poiseugm.net', 'POISE UGM');
$mail->addAddress($_POST['email'], $_POST['name']);
$mail->isHTML(true);
$mail->Subject = 'Notifikasi pendaftaran POISETalks';
$recname = $_POST['name'];
$mail->Body = "Dear ,<br><br>Congratulations, you have sucessfully signed oup on our following POISETalks webinars:<ul> $x </ul>We are hoping for you to have such a marvelous experience and gain a better understanding about safety & green industry culture for sustainable future.<br>We are very excited and looking forward for your participation.<br><br>Let us know if you have any further questions by contacting:<br>LINE: @poiseugm2021 (POISE UGM)<br>Nabila: 081293934283 (WhatsApp)<br>Natasha: 087898502471 (WhatsApp)<br><br>Best regards,<br>POISE UGM";
$mail->send();
if ($dbconfirm == 1 && $upconfirm == 1) {
    header("Location: https://dev.poiseugm.net/events/poisetalks/success.html");
} else {
    header("Location: https://dev.poiseugm.net/events/poisetalks/failed.html");
}
?>

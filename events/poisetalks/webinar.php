<?php
$path = '../../frameworks/php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../frameworks/php/PHPMailer/src/Exception.php';
require '../../frameworks/php/PHPMailer/src/PHPMailer.php';
require '../../frameworks/php/PHPMailer/src/SMTP.php';

$webinar1 = 0;
$webinar2 = 0;
$webinar3 = 0;
$webinar4 = 0;
$webinar5 = 0;
$dbconfirm = 0;
$upconfirm = 0;

date_default_timezone_set('Asia/Jakarta');
$uploaddir = '../../../uploads/poisetalks/webinar/';
$curdate = date('Y-m-d');
$tiem = date('H:i:s');
$un = '_';
$filedate = $curdate . $un . $tiem;
$nameformat = $filedate . $un . basename($_FILES['twib']['name']);
$uploadfile = $uploaddir . $nameformat;
if (move_uploaded_file($_FILES['twib']['tmp_name'], $uploadfile)) {
    $upconfirm = 1;
} else {
    $upconfirm = 0;
}

$webinar1 = $_POST['webinar1'];
$webinar2 = $_POST['webinar2'];
$webinar3 = $_POST['webinar3'];
$webinar4 = $_POST['webinar4'];
$webinar5 = $_POST['webinar5'];

$username = "poiq2362_admin";
$passwd = "Su.}6U46?l%P";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $mysqli = new mysqli("127.0.0.1", "$username", "$passwd", "poiq2362_poisetalks", 3306);
  $mysqli->set_charset("utf8mb4");
  $dbconfirm = 1;
} catch(Exception $e) {
  error_log($e->getMessage());
  $dbconfirm = 0;
}
$mysqli->set_charset("utf8mb4");
$x = "";

if ($webinar1 == 1) {
    $x .= "<li>POISETalks 1: FMCG</li>";
    $stmt = $mysqli->prepare("INSERT INTO webinar1 (name, email, dob, gender, phone, institution, filename) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution'], $nameformat);
    $stmt->execute();
    $stmt->close();
}
if ($webinar2 == 1) {
    $x .= "<li>POISETalks 2: Nickel Industry</li>";
    $stmt = $mysqli->prepare("INSERT INTO webinar2 (name, email, dob, gender, phone, institution, filename) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution'], $nameformat);
    $stmt->execute();
    $stmt->close();
}
if ($webinar3 == 1) {
    $x .= "<li>POISETalks 3: Renewable energy</li>";
    $stmt = $mysqli->prepare("INSERT INTO webinar3 (name, email, dob, gender, phone, institution, filename) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution'], $nameformat);
    $stmt->execute();
    $stmt->close();
}
if ($webinar4 == 1) {
    $x .= "<li>POISETalks 4: Diversity and Inclusion in Engineering</li>";
    $stmt = $mysqli->prepare("INSERT INTO webinar4 (name, email, dob, gender, phone, institution, filename) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution'], $nameformat);
    $stmt->execute();
    $stmt->close();
}
if ($webinar5 == 1) {
    $x .= "<li>POISETalks 5: Challenge in Sustainable Industry</li>";
    $stmt = $mysqli->prepare("INSERT INTO webinar5 (name, email, dob, gender, phone, institution, filename) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution'], $nameformat);
    $stmt->execute();
    $stmt->close();
}

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'mail.poiseugm.net';
$mail->Port       = 465;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->SMTPAuth   = true;
$mail->Username   = 'notifikasi@poiseugm.net';
$mail->Password   = '({A=&=32~Kn;a@0$>?};9+I&W}?a\P';
$mail->setFrom('notifikasi@poiseugm.net', 'POISE UGM');
$mail->addAddress($_POST['email'], $_POST['name']);
$mail->isHTML(true);
$mail->Subject = 'Notifikasi pendaftaran POISETalks';
$recname = $_POST['name'];
$mail->Body = "Dear $recname,<br><br>Congratulations, you have sucessfully signed oup on our following POISETalks webinars:<ul> $x </ul>We are hoping for you to have such a marvelous experience and gain a better understanding about safety & green industry culture for sustainable future.<br>We are very excited and looking forward for your participation.<br><br>Let us know if you have any further questions by contacting:<br>LINE: @poiseugm2021 (POISE UGM)<br>Nabila: 081293934283 (WhatsApp)<br>Natasha: 087898502471 (WhatsApp)<br><br>Best regards,<br>POISE UGM";
$mail->send();
$hostnaem  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$suc = 'success.html';
$fai = 'failed.html';
if ($dbconfirm == 1 && $upconfirm == 1) {
    header("Location: https://$hostnaem$uri/$suc");
} else {
    header("Location: https://$hostnaem$uri/$fai");
}
?>

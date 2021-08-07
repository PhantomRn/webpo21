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
$uploaddir = '../../../uploads/phase/';
$curdate = date('Y-m-d');
$tiem = date('H:i:s');
$un = '_';
$filedate = $curdate . $un . $tiem;
$nameformat = $filedate . $un . basename($_FILES['phasedata']['name']);
$uploadfile = $uploaddir . $nameformat;
if (move_uploaded_file($_FILES['phasedata']['tmp_name'], $uploadfile)) {
    $upconfirm = 1;
} else {
    $upconfirm = 0;
}

$username = "poiq2362_uphase";
$passwd = "îÖA©Þ%xM¬¨)v9ñm²¶²3KöZ°¸²G[ÇY£";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $mysqli = new mysqli("127.0.0.1", "$username", "$passwd", "poiq2362_phase", 3306);
    $mysqli->set_charset("utf8mb4");
    $dbconfirm = 1;
} catch(Exception $e) {
    error_log($e->getMessage());
    $dbconfirm = 0;
}
$stmt = $mysqli->prepare("INSERT INTO phase (tname, inst, lname, lmaj, lbatch, phone, email, mname, mmaj, mbatch, payment, filen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssss",$_POST['tname'], $_POST['inst'], $_POST['lname'], $_POST['lmaj'], $_POST['lbatch'], $_POST['phone'], $_POST['email'], $_POST['mname'], $_POST['mmaj'], $_POST['mbatch'], $_POST['payment'], $nameformat);
$stmt->execute();
$idnum = mysqli_insert_id($mysqli);
$stmt->close();

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'mail.poiseugm.net';
$mail->SMTPAuth   = true;
$mail->Username   = 'notifikasi@poiseugm.net';
$mail->Password   = '/Ö|:@9¬îjEßÊ`ôh÷¸<"+íôÖc*öä<Ü&';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = 465;
$mail->setFrom('notifikasi@poiseugm.net', 'POISE UGM');
$mail->addAddress($_POST['email'], $_POST['lname']);
$mail->isHTML(true);
$mail->Subject = 'REGISTRATION NOTIFICATION : 2021';
$recname = $_POST['tname'];
$mail->Body = "Dear $recname,<br><br>Thank you for signing up for our Poster Challenge for Decent Engineer (PHASE) in POISE 2021. We have received all documents accordingly and we will be verifying your payment. It will take 2x24 hours for the verification process. Please wait for the next email from us.<br><br>We are very excited and looking forward to your participation.<br><br>Let us know if you have any further questions by contacting:<br>LINE: @poiseugm2021 (POISE UGM)<br>Kennard : 0895392202576 (WhatsApp)<br>Alfian : 082220723862 (WhatsApp)<br><br>Best regards,<br>POISE UGM<br><br>---<br>Reach us for more information on <a href=\"https://linktr.ee/poiseugm\">linktree</a>";
$mail->send();

$hostnaem = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$suc = 'success.html';
$fai = 'failed.html';
if ($dbconfirm == 1 && $upconfirm == 1) {
    header("Location: https://$hostnaem$uri/$suc");
} else {
    header("Location: https://$hostnaem$uri/$fai");
}
?>

<?php
$path = '../../frameworks/php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../frameworks/php/PHPMailer/src/Exception.php';
require '../../frameworks/php/PHPMailer/src/PHPMailer.php';
require '../../frameworks/php/PHPMailer/src/SMTP.php';

$username = "poiq2362_admin";
$passwd = "Su.}6U46?l%P";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $mysqli = new mysqli("127.0.0.1", "$username", "$passwd", "poiq2362_form_dev", 3306);
  $mysqli->set_charset("utf8mb4");
  echo "Data recorded";
} catch(Exception $e) {
  error_log($e->getMessage());
  exit('Something went wrong!');
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
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'localhost';
$mail->setFrom('notifikasi@poiseugm.net', 'POISE UGM');
$mail->addAddress($_POST['email'], $_POST['name']);
$mail->isHTML(true);
$mail->Subject = 'Notifikasi pendaftaran webinar POISE';
$mail->Body = "Anda telah terdaftar dalam webinar <ul> $x </ul>";
$mail->send();
?>

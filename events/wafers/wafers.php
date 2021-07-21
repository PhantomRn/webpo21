<?php
$path = '../../frameworks/php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../frameworks/php/PHPMailer/src/Exception.php';
require '../../frameworks/php/PHPMailer/src/PHPMailer.php';
require '../../frameworks/php/PHPMailer/src/SMTP.php';

$username = "poiq2362_uwafers";
$passwd = "Ì4U/Ä§Ûiýnu±?ô5vÑ*ñ½6ZùPþÍù]ã{Ïd";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $mysqli = new mysqli("127.0.0.1", "$username", "$passwd", "poiq2362_wafers", 3306);
    $mysqli->set_charset("utf8mb4");
    $dbconfirm = 1;
} catch(Exception $e) {
    error_log($e->getMessage());
    $dbconfirm = 0;
}
$m1 = 0;
$m2 = 0;
$m3 = 0;
$m4 = 0;
$m5 = 0;
$m6 = 0;

$m1 = $_POST['m1'];
$m2 = $_POST['m2'];
$m3 = $_POST['m3'];
$m4 = $_POST['m4'];
$m5 = $_POST['m5'];
$m6 = $_POST['m6'];

$stmt = $mysqli->prepare("INSERT INTO wafers (name, email, institution, country, m1, m2, m3, m4, m5, m6) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssiiiiii",$_POST['name'], $_POST['email'], $_POST['inst'], $_POST['country'], $m1, $m2, $m3, $m4, $m5, $m6);
$stmt->execute();
$stmt->close();

$module_list = "";
if($m1 == 1):
    $module_list .= "<li>Sustainable Food Production</li>";
if($m2 == 1):
    $module_list .= "<li>Biogas as a Renewable Energy Source</li>";
if($m3 == 1):
    $module_list .= "<li>Renewable Energy</li>";
if($m4 == 1):
    $module_list .= "<li>Wastewater Treatment</li>";
if($m5 == 1):
    $module_list .= "<li>Clean Water Technology</li>";
if($m6 == 1):
    $module_list .= "<li>Green Energy Sources</li>";
    
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
$mail->Subject = 'REGISTRATION NOTIFICATION : WAFERS Online Summer Course 2021';
$mail->addEmbeddedImage('reg.jpg','QR','QR.jpg');
$recname = $_POST['name'];
$mail->Body = "Dear $recname,<br><br>Congratulations, you have sucessfully signed up on our following WAFERS 2021 webinars:<ul>$module_list</ul><br>Here is the virtual conference link for the webinars: <img src=\"cid:QR\"><br><br>Please do not share the link. Keep in mind that all the webinars will have same zoom meeting link, register yourself before joining the webinars to make the administration easier.<br><br>We are hoping for you to have such a marvelous experience and gain a better understanding about water, food, and energy.<br><br>Let us know if you have any further questions by contacting:<br>LINE: @poiseugm2021 (POISE UGM)<br>Irene: +628126522350<br>Satya: +6285253813929<br><br>Best regards,<br>WAFERS Online Summer Course 2021";
$mail->send();

$hostnaem  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$suc = 'success.html';
$fai = 'failed.html';
if ($dbconfirm == 1) {
    header("Location: https://$hostnaem$uri/$suc");
} else {
    header("Location: https://$hostnaem$uri/$fai");
}
?>

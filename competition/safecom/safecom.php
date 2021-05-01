<?php
$path = '../../frameworks/php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

$dbconfirm = 0;
$upconfirm = 0;

date_default_timezone_set('Asia/Jakarta');
$uploaddir = '../../../uploads/safecom/';
$curdate = date('Y-m-d');
$tiem = date('H:i:s');
$un = '_';
$filedate = $curdate . $un . $tiem;
$nameformat = $filedate . $un . basename($_FILES['safedata']['name']);
$uploadfile = $uploaddir . $nameformat;
if (move_uploaded_file($_FILES['safedata']['tmp_name'], $uploadfile)) {
    $upconfirm = 1;
} else {
    $upconfirm = 0;
}

$username = "poiq2362_admin";
$passwd = "Su.}6U46?l%P";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $mysqli = new mysqli("127.0.0.1", "$username", "$passwd", "poiq2362_safecom", 3306);
  $mysqli->set_charset("utf8mb4");
  $dbconfirm = 1;
} catch(Exception $e) {
  error_log($e->getMessage());
  $dbconfirm = 0;
}
$mysqli->set_charset("utf8mb4");

$stmt = $mysqli->prepare("INSERT INTO safecom (tname, inst, lname, lmaj, lbatch, phone, email, mname1, mmaj1, mbatch1, mname2, mmaj2, mbatch2, filen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssssss",$_POST['tname'], $_POST['inst'], $_POST['lname'], $_POST['lmaj'], $_POST['lbatch'], $_POST['phone'], $_POST['email'], $_POST['mname1'], $_POST['mmaj1'], $_POST['mbatch1'], $_POST['mname2'], $_POST['mmaj2'], $_POST['mbatch2'], $nameformat);
$stmt->execute();
$idnum = mysqli_insert_id($mysqli);
$stmt->close();

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

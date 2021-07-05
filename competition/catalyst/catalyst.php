<?php

$dbconfirm = 0;
$upconfirm = 0;
$uploaddir = '../../../uploads/catalyst/';
$curdate = date('Y-m-d');
$tiem = date('H:i:s');
$un = '_';
$filedate = $curdate . $un . $tiem;
$nameformat = $filedate . $un . basename($_FILES['catadata']['name']);
$uploadfile = $uploaddir . $nameformat;
if (move_uploaded_file($_FILES['catadata']['tmp_name'], $uploadfile)) {
    $upconfirm = 1;
} else {
    $upconfirm = 0;
}

$username = "poiq2362_admin";
$passwd = "Su.}6U46?l%P";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $mysqli = new mysqli("127.0.0.1", "$username", "$passwd", "poiq2362_catalyst", 3306);
  $mysqli->set_charset("utf8mb4");
  $dbconfirm = 1;
} catch(Exception $e) {
    error_log($e->getMessage());
    $dbconfirm = 0;
}
$stmt = $mysqli->prepare("INSERT INTO catalyst (tname, email, lname, lineid, phone, mname1, mname2, inst, payment, filen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss",$_POST['tname'], $_POST['email'], $_POST['lname'], $_POST['lineid'], $_POST['phone'], $_POST['mname1'], $_POST['mname2'], $_POST['inst'], $_POST['payment'], $nameformat);
$stmt->execute();
$idnum = mysqli_insert_id($mysqli);
$stmt->close();

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

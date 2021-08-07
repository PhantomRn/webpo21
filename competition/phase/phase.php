<?php

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
$stmt->bind_param("ssssssssss",$_POST['tname'], $_POST['inst'], $_POST['lname'], $_POST['lmaj'], $_POST['lbatch'], $_POST['phone'], $_POST['email'], $_POST['mname'], $_POST['mmaj'], $_POST['mbatch'], $_POST['payment'], $nameformat);
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

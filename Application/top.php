<?php
error_reporting(1);
ob_start();
session_start();
include_once '../db.php';
if (!isset($_SESSION['ID'])) {
    echo "<meta http-equiv='refresh' content='0;url=http://localhost/voters/'>";
}
date_default_timezone_set("Asia/Kathmandu");
$userid = $_SESSION['ID'];
$q = mysqli_query($connection, "select * from admin where ID = '$userid'")or die(mysqli_error($connection));
$row = mysqli_fetch_assoc($q);
$isadmin = $row['IsAdmin'];
$email = $row['Email'];
include_once '../js/nepali_calendar.php';
include_once '../js/functions.php';
$date = date('Y-m-d');
$cal = new Nepali_Calendar();
list($yr1, $mn1, $dy1) = explode("-", $date);
$npdate = $cal->eng_to_nep($yr1, $mn1, $dy1);
$yr = $npdate['year'];
$mn = $npdate['month'];
$dy = $npdate['date'];
$cdate = $yr . "/" . $mn . "/" . $dy;
?>


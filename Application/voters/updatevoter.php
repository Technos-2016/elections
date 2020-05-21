<?php

session_start();
include_once '../../db.php';
if (isset($_POST["update"])) {
    $userid = mysqli_real_escape_string($connection, $_POST["userid"]);
    $name = mysqli_real_escape_string($connection, $_POST["name"]);
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $mobile = mysqli_real_escape_string($connection, $_POST["mobile"]);
    $password = mysqli_real_escape_string($connection, $_POST["pass"]);
    $pass = mysqli_real_escape_string($connection, md5($_POST["pass"]));
    
    $query = "UPDATE voterslist SET Name = '$name', Email = '$email', Password = '$password',Pass = '$pass',Mobile = '$mobile'  WHERE ID = '$userid'";
    $update = mysqli_query($connection, $query) or die(print_r(mysqli_error($connection)));
    if ($update) {
        echo "<script type='text/javascript'>alert('Successfully Updated the Details!');</script>";
        echo "<script>window.location='../voterslist.php'</script>";
    } else {
        echo "<script type='text/javascript'>alert('Error Updating the Details');</script>";
        echo "<script>window.location='../voterslist.php'</script>";
    }
}
?>


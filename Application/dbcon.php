<?php
error_reporting(1);
$connection = mysqli_connect("localhost","root","","voters");
if (mysqli_connect_errno($connection)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error($connection);
}


?>
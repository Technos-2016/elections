<?php

$db['db_host'] = 'localhost';
$db['db_user'] = 'root';
$db['db_pass'] = '';
$db['db_name'] = 'voters';
foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$connection) {
    echo "Error Connecting Database";
    exit(0);
}

define("TITLE","CAST YOUR VOTE");
define("COPYRIGHT","http://localhost://voters");
define("WEBADDRESS", "http://localhost/voters/");
define("CURADDRESS", "http://localhost/voters/Application/");
?>



<?php
session_start();
unset($_SESSION['ID']);
session_destroy();
echo "<meta http-equiv='refresh' content='0;url=http://localhost/voters'>";
?>
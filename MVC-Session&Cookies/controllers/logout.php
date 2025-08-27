<?php
session_start();
unset($_SESSION['status']);
setcookie('username', '', time() - 10, '/');
setcookie('password', '', time() - 10, '/');
header("location: ../views/login.php");
?>

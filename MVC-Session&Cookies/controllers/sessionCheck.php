<?php
session_start();
if (!isset($_SESSION['status'])) {
    header('location: ../views/login.php?error=badrequest');
}
?>

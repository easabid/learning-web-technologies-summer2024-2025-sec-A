<?php
session_start();
if (!isset($_SESSION['status']) || !isset($_SESSION['role']) || !isset($_SESSION['username'])) {
    header('location: ../views/login.php?error=badrequest');
    exit;
}
?>

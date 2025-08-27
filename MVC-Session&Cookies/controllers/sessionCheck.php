<?php
session_start();

// If not logged in → go back to login
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php?error=unauthorized");
    exit;
}

// Optional: role-based restriction
function requireRole($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header("Location: ../views/login.php?error=forbidden");
        exit;
    }
}

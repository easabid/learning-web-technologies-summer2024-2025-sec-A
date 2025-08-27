<?php
session_start();

// Hardcoded users for testing (no database)
$users = [
    "admin"     => "admin123",
    "employer"  => "employer123",
    "jobseeker" => "job123"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (isset($users[$username]) && $users[$username] === $password) {
        // Store session
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $username;

        // Redirect based on role → correct relative path
        if ($username === "admin") {
            header("Location: ../views/admin.php");
            exit;
        } elseif ($username === "employer") {
            header("Location: ../views/employer.php");
            exit;
        } elseif ($username === "jobseeker") {
            header("Location: ../views/jobseeker.php");
            exit;
        }
    } else {
        // Wrong login → back to login page
        header("Location: ../views/login.php?error=1");
        exit;
    }
} else {
    // If accessed directly, redirect to login
    header("Location: ../views/login.php");
    exit;
}

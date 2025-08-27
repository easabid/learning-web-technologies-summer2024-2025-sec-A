<?php
session_start();

// Get inputs
$username     = trim($_POST['username']);
$email        = trim($_POST['email']);
$password     = trim($_POST['password']);
$confirmpass  = trim($_POST['confirmpassword']);
$role         = trim($_POST['role']);

// --- Validation ---
if ($username == "" || $email == "" || $password == "" || $confirmpass == "" || $role == "") {
    header("location: ../views/register.php?error=null");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("location: ../views/register.php?error=invalid_email");
    exit;
}

if ($password !== $confirmpass) {
    header("location: ../views/register.php?error=password_mismatch");
    exit;
}

// --- Hardcoded users (demo) ---
$users = [
    ["username" => "admin", "email" => "admin@gmail.com", "password" => "admin123", "role" => "admin"],
    ["username" => "employer", "email" => "employer@gmail.com", "password" => "employer123", "role" => "employer"],
    ["username" => "jobseeker", "email" => "jobseeker@gmail.com", "password" => "job123", "role" => "jobseeker"]
];

// --- Check if username/email already exists ---
foreach ($users as $user) {
    if ($user['username'] === $username) {
        header("location: ../views/register.php?error=user_exists");
        exit;
    }
    if ($user['email'] === $email) {
        header("location: ../views/register.php?error=email_exists");
        exit;
    }
}

// --- Simulate successful registration ---
$_SESSION['status']   = true;
$_SESSION['username'] = $username;
$_SESSION['role']     = $role;

// Auto redirect based on role
if ($role == "admin") {
    header("location: ../views/admin.php?msg=registered");
} elseif ($role == "employer") {
    header("location: ../views/employer.php?msg=registered");
} else {
    header("location: ../views/jobseeker.php?msg=registered");
}
exit;
?>

<?php
session_start();

$username = trim($_POST['username']);
$password = trim($_POST['password']);
$remember = isset($_POST['remember']);

if ($username == "" || $password == "") {
    header("location: ../views/login.php?error=null");
    exit;
}

// simulate user database
$users = [
    "admin"    => "admin123",
    "employer" => "employer123",
    "jobseeker"=> "job123"
];

if (array_key_exists($username, $users) && $users[$username] === $password) {
    // success
    $_SESSION['status'] = true;
    $_SESSION['username'] = $username;

    if ($remember) {
        setcookie('username', $username, time() + 3000, '/');
        setcookie('password', $password, time() + 3000, '/');
    } else {
        setcookie('username', '', time() - 10, '/');
        setcookie('password', '', time() - 10, '/');
    }

    // redirect based on role
    if ($username == "admin") {
        header("location: ../views/admin.php");
    } elseif ($username == "employer") {
        header("location: ../views/employer.php");
    } else {
        header("location: ../views/jobseeker.php");
    }
    exit;

} else {
    header("location: ../views/login.php?error=invalid");
    exit;
}

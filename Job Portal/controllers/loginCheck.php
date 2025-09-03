<?php
session_start();

$username = trim($_POST['username']);
$password = trim($_POST['password']);
$remember = isset($_POST['remember']);

if ($username == "" || $password == "") {
    header("location: ../views/login.php?error=null");
    exit;
}

$users = [
    "admin"    => "admin",
    "employer" => "employer",
    "jobseeker"=> "job"
];

if (array_key_exists($username, $users) && $users[$username] === $password) {
    $_SESSION['status'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $username; //  username is same as role 

    if ($remember) {
        setcookie('username', $username, time() + 3000, '/');
        setcookie('password', $password, time() + 3000, '/');
    } else {
        setcookie('username', '', time() - 10, '/');
        setcookie('password', '', time() - 10, '/');
    }

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

<?php
    session_start();
    require_once('../model/adminModel.php');

    $username = trim($_REQUEST['username']);
    $password = trim($_REQUEST['password']);

    if($username == "" || $password == ""){
        header('location: ../view/login.php?error=null');
    }else{
            $user = ['username'=> $username, 'password'=>$password];
            $status = login($user);
            if($status){
                $userDetails = getUserByUsername($username);
                $_SESSION['user'] = $userDetails;
                header('location: ../view/admin.php');
            }else{
                header('location: ../view/login.php?error=invalid');
            }
    }
?>


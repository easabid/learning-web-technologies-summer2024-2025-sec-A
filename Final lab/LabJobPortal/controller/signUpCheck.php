<?php

    require_once('../model/adminModel.php');

    $username = trim($_REQUEST['username']);
    $password = trim($_REQUEST['password']);
    $email = trim($_REQUEST['email']);

    if($username == "" || $password == "" || $email == ""){
        header('location: ../view/Signup.php?error=null');
    }else{
        $employer = [
            'emp_name'=> $username,  
            'company_name'=> 'Null',  
            'contact_no'=> 'Null',    
            'user_name'=> $username,
            'password'=> $password
        ];
        
        $status = registerEmployer($employer);  
        if($status){
            header('location: ../view/login.php');
        }else{
            header('location: ../view/Signup.php?error=dberror');
        }
    }

?>
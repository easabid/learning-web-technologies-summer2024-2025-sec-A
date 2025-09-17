<?php

    require_once('db.php');

function login($user){
    $con = getConnection();
    $sql = "select * from employers where User_Name='{$user['username']}' and Password='{$user['password']}'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);

    if($count == 1){
        return true;
    }else{
        return false;
    }
}

function getUserByUsername($username){
    $con = getConnection();
    $sql = "select * from employers where User_Name='{$username}'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user;
}

function getEmployerById($id){
    $con = getConnection();
    $sql = "select * from employers where id={$id}";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function registerEmployer($employer){
    $con = getConnection();
    $sql = "insert into employers values(null, '{$employer['emp_name']}', '{$employer['company_name']}', '{$employer['contact_no']}', '{$employer['user_name']}', '{$employer['password']}')";
    if(mysqli_query($con, $sql)){
        return true;
    }else{
        return false;
    }
}

function deleteEmployer($id){
    $con = getConnection();
    $sql = "delete from employers where id={$id}";
    if(mysqli_query($con, $sql)){
        return true;
    }else{
        return false;
    }
}

function getAllEmployers(){
    $con = getConnection();
    $sql = "select * from employers";
    $result = mysqli_query($con, $sql);
    $employers = [];

    while($row = mysqli_fetch_assoc($result)){
        array_push($employers, $row);
    }

    return $employers;
}

function updateEmployer($employer){
    $con = getConnection();
    $sql = "update employers set Emp_name='{$employer['emp_name']}', Company_name='{$employer['company_name']}', Contact_No='{$employer['contact_no']}', User_Name='{$employer['user_name']}', Password='{$employer['password']}' where id={$employer['id']}";
    if(mysqli_query($con, $sql)){
        return true;
    }else{
        return false;
    }
}

?>



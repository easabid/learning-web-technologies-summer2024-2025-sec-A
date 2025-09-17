<?php

    require_once('../model/adminModel.php');

if(isset($_POST['register_employer'])){
    $employer = array(
        'emp_name' => $_POST['emp_name'],
        'company_name' => $_POST['company_name'],
        'contact_no' => $_POST['contact_no'],
        'user_name' => $_POST['user_name'],
        'password' => $_POST['password']
    );

    if(registerEmployer($employer)){
        //echo "registered successfully!";
        header('Location: ../view/admin.php');
    }else{
        echo "Failed ";
    }
}


if(isset($_POST['update_employer'])){
    $employer = array(
        'id' => $_POST['id'],
        'emp_name' => $_POST['emp_name'],
        'company_name' => $_POST['company_name'],
        'contact_no' => $_POST['contact_no'],
        'user_name' => $_POST['user_name'],
        'password' => $_POST['password']
    );

    if(updateEmployer($employer)){
        //echo "Employer information updated successfully!";
        header('Location: ../view/admin.php');
    }else{
        echo "Failed to update employer information!";
    }
}





if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    
    if(deleteEmployer($id)){
        //echo "Employer deleted successfully!";
        header('Location: ../view/admin.php');
    }else{
        //echo "Failed to delete employer!";
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'get_all_employers'){
    $employers = getAllEmployers();
    return $employers;
}

if(isset($_GET['edit_id'])){
    $id = $_GET['edit_id'];
    $employer = getEmployerById($id);
    return $employer;
}

?>

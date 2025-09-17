<?php
    require_once('../model/adminModel.php');
    
    // Handle GET request to display employers for updating
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(isset($_GET['id'])) {
            // Get specific employer for editing
            $employer = getEmployerById($_GET['id']);
            return $employer;
        } else {
            // Get all employers for selection
            $employers = getAllEmployers();
            return $employers;
        }
    }
    
    // Handle POST request to update employer
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_employer'])) {
        $employer = array(
            'id' => $_POST['id'],
            'emp_name' => $_POST['emp_name'],
            'company_name' => $_POST['company_name'],
            'contact_no' => $_POST['contact_no'],
            'user_name' => $_POST['user_name'],
            'password' => $_POST['password']
        );

        if(updateEmployer($employer)){
            header('Location: ../view/admin.php?success=updated');
        }else{
            header('Location: ../view/update_info.php?error=update_failed');
        }
        exit();
    }
?>
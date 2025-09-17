<?php
    require_once('../model/adminModel.php');
    
    // Handle GET request to display employers for deletion
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(isset($_GET['delete_id'])) {
            // Delete specific employer
            $id = $_GET['delete_id'];
            if(deleteEmployer($id)){
                header('Location: ../view/admin.php?success=deleted');
            }else{
                header('Location: ../view/delete_employer.php?error=delete_failed');
            }
            exit();
        } else {
            // Get all employers for selection
            $employers = getAllEmployers();
            return $employers;
        }
    }
?>
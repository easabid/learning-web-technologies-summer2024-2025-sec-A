<?php

    require_once('../model/adminModel.php');

function getAllEmployersController(){
    return getAllEmployers();
}

function getEmployerByIdController($id){
    return getEmployerById($id);
}

function searchEmployersController($searchTerm, $searchBy){
    $allEmployers = getAllEmployers();
    $searchResults = [];
    
    foreach($allEmployers as $employer){
        if($searchBy == 'emp_name' && stripos($employer['Emp_name'], $searchTerm) !== false){
            $searchResults[] = $employer;
        }
        elseif($searchBy == 'company_name' && stripos($employer['Company_name'], $searchTerm) !== false){
            $searchResults[] = $employer;
        }
        elseif($searchBy == 'contact_no' && stripos($employer['Contact_No'], $searchTerm) !== false){
            $searchResults[] = $employer;
        }
        elseif($searchBy == 'user_name' && stripos($employer['User_Name'], $searchTerm) !== false){
            $searchResults[] = $employer;
        }
        elseif($searchBy == 'all' && (
            stripos($employer['Emp_name'], $searchTerm) !== false ||
            stripos($employer['Company_name'], $searchTerm) !== false ||
            stripos($employer['Contact_No'], $searchTerm) !== false ||
            stripos($employer['User_Name'], $searchTerm) !== false
        )){
            $searchResults[] = $employer;
        }
    }
    return $searchResults;
}

if(isset($_POST['ajax_search'])){    
    $searchTerm = isset($_POST['search_term']) ? trim($_POST['search_term']) : '';
    
    if(!empty($searchTerm)){
        $results = searchEmployersController($searchTerm, 'emp_name');
    } else {
        $results = getAllEmployersController();
    }
    
    echo json_encode($results);
    exit();
}

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

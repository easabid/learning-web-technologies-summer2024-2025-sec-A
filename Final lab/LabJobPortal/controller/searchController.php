<?php
    require_once('../model/adminModel.php');
    
    $searchResults = [];
    $searchPerformed = false;
    $allEmployers = [];
    
    // Handle POST request for search
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
        $searchTerm = $_POST['search_term'];
        $searchBy = $_POST['search_by'];
        
        $allEmployers = getAllEmployers();
        
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
        $searchPerformed = true;
    }
    
    // Handle GET request to display all employers
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $allEmployers = getAllEmployers();
    }
?>
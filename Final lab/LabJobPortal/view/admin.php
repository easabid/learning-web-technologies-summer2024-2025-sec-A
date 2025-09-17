<?php
    session_start();
    
    if(!isset($_SESSION['user'])){
        header('location: login.php');
        exit();
    }
    
    $user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <div>
        <div class="header">Admin Dash</div>
        
        <div>
            <h1>Welcome <?= $user['User_Name'] ?></h1>
        </div>
        
        <div>
            <a href="add_new_employer.php">Add New Employer</a> <br><br>
            <a href="update_info.php">Update Info.</a> <br><br>
            <a href="delete_employer.php">Delete Employer</a> <br><br>
            <a href="search_employer.php">Search Employer</a> <br><br>
            <a href="../controller/logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
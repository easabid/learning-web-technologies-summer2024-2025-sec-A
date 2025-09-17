<?php
    require_once('../controller/searchController.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Employer</title>
</head>
<body>
    <h2>Search Employer</h2>
    
    <form method="POST">
        <table>
            <tr>
                <td>Search By:</td>
                <td>
                    <select name="search_by">
                        <option value="all" <?php echo (isset($_POST['search_by']) && $_POST['search_by'] == 'all') ? 'selected' : ''; ?>>All Fields</option>
                        <option value="emp_name" <?php echo (isset($_POST['search_by']) && $_POST['search_by'] == 'emp_name') ? 'selected' : ''; ?>>Employer Name</option>
                        <option value="company_name" <?php echo (isset($_POST['search_by']) && $_POST['search_by'] == 'company_name') ? 'selected' : ''; ?>>Company Name</option>
                        <option value="contact_no" <?php echo (isset($_POST['search_by']) && $_POST['search_by'] == 'contact_no') ? 'selected' : ''; ?>>Contact Number</option>
                        <option value="user_name" <?php echo (isset($_POST['search_by']) && $_POST['search_by'] == 'user_name') ? 'selected' : ''; ?>>User Name</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Search Term:</td>
                <td><input type="text" name="search_term" value="<?php echo isset($_POST['search_term']) ? $_POST['search_term'] : ''; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="search" value="Search">
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>
    
    <?php if($searchPerformed): ?>
        <h3>Search Results</h3>
        <?php if(count($searchResults) > 0): ?>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Employer Name</th>
                    <th>Company Name</th>
                    <th>Contact No</th>
                    <th>User Name</th>
                    <th>Actions</th>
                </tr>
                <?php foreach($searchResults as $employer): ?>
                <tr>
                    <td><?php echo $employer['id']; ?></td>
                    <td><?php echo $employer['Emp_name']; ?></td>
                    <td><?php echo $employer['Company_name']; ?></td>
                    <td><?php echo $employer['Contact_No']; ?></td>
                    <td><?php echo $employer['User_Name']; ?></td>
                    <td>
                        <a href="update_info.php?id=<?php echo $employer['id']; ?>">Edit</a> | 
                        <a href="delete_employer.php">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <p>Found <?php echo count($searchResults); ?> result(s).</p>
        <?php else: ?>
            <p>No employers found matching your search criteria.</p>
        <?php endif; ?>
    <?php endif; ?>
    
    <br>
    <h3>All Employers</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Employer Name</th>
            <th>Company Name</th>
            <th>Contact No</th>
            <th>User Name</th>
            <th>Actions</th>
        </tr>
        <?php
            $allEmployers = getAllEmployers();
            foreach($allEmployers as $employer):
        ?>
        <tr>
            <td><?php echo $employer['id']; ?></td>
            <td><?php echo $employer['Emp_name']; ?></td>
            <td><?php echo $employer['Company_name']; ?></td>
            <td><?php echo $employer['Contact_No']; ?></td>
            <td><?php echo $employer['User_Name']; ?></td>
            <td>
                <a href="update_info.php?id=<?php echo $employer['id']; ?>">Edit</a> | 
                <a href="delete_employer.php">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <?php if(empty($allEmployers)): ?>
        <p>No employers found in the database.</p>
    <?php endif; ?>
    
    <br>
    <a href="admin.php">Back to Admin Panel</a>
</body>
</html>
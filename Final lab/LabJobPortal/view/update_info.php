<?php
    require_once('../controller/adminActions.php');
    
    $employer = null;
    if(isset($_GET['id'])){
        $employer = getEmployerByIdController($_GET['id']);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Employer Information</title>
</head>
<body>
    <h2>Update Employer Information</h2>
    
    <?php if(!$employer): ?>
        <table border="1" rules="all">
            <tr>
                <th>ID</th>
                <th>Employer Name</th>
                <th>Company Name</th>
                <th>Contact No</th>
                <th>User Name</th>
                <th>Action</th>
            </tr>
            <?php
                $employers = getAllEmployersController();
                foreach($employers as $emp):
            ?>
            <tr>
                <td><?php echo $emp['id']; ?></td>
                <td><?php echo $emp['Emp_name']; ?></td>
                <td><?php echo $emp['Company_name']; ?></td>
                <td><?php echo $emp['Contact_No']; ?></td>
                <td><?php echo $emp['User_Name']; ?></td>
                <td><a href="update_info.php?id=<?php echo $emp['id']; ?>">Edit</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <h3>Update Employer: <?php echo $employer['Emp_name']; ?></h3>
        
        <form action="../controller/adminActions.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $employer['id']; ?>">
            <table>
                <tr>
                    <td>Employer Name:</td>
                    <td><input type="text" name="emp_name" value="<?php echo $employer['Emp_name']; ?>" required></td>
                </tr>
                <tr>
                    <td>Company Name:</td>
                    <td><input type="text" name="company_name" value="<?php echo $employer['Company_name']; ?>" required></td>
                </tr>
                <tr>
                    <td>Contact No:</td>
                    <td><input type="text" name="contact_no" value="<?php echo $employer['Contact_No']; ?>" required></td>
                </tr>
                <tr>
                    <td>User Name:</td>
                    <td><input type="text" name="user_name" value="<?php echo $employer['User_Name']; ?>" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" value="<?php echo $employer['Password']; ?>" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="update_employer" value="Update Employer">
                        <input type="reset" value="Reset">
                    </td>
                </tr>
            </table>
        </form>
    <?php endif; ?>
    
    <br>
    <a href="admin.php">Back to Admin Panel</a>
</body>
</html>
<?php
    require_once('../controller/deleteController.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Employer</title>
    <script>
        function confirmDelete(empName, id) {
            if(confirm("Are you sure you want to delete employer: " + empName + "?")) {
                window.location.href = "../controller/deleteController.php?delete_id=" + id;
            }
        }
    </script>
</head>
<body>
    <h2>Delete Employer</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Employer Name</th>
            <th>Company Name</th>
            <th>Contact No</th>
            <th>User Name</th>
            <th>Action</th>
        </tr>
        <?php
            $employers = getAllEmployers();
            foreach($employers as $employer):
        ?>
        <tr>
            <td><?php echo $employer['id']; ?></td>
            <td><?php echo $employer['Emp_name']; ?></td>
            <td><?php echo $employer['Company_name']; ?></td>
            <td><?php echo $employer['Contact_No']; ?></td>
            <td><?php echo $employer['User_Name']; ?></td>
            <td>
                <button onclick="confirmDelete('<?php echo $employer['Emp_name']; ?>', <?php echo $employer['id']; ?>)">
                    Delete
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <?php if(empty($employers)): ?>
        <p>No employers found.</p>
    <?php endif; ?>
    
    <br>
    <a href="admin.php">Back to Admin Panel</a>
</body>
</html>
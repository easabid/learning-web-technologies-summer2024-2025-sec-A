<!DOCTYPE html>
<html>
<head>
    <title>Add New Employer</title>
</head>
<body>
    <h2>Add New Employer</h2>
    
    <form action="../controller/adminActions.php" method="POST">
        <table>
            <tr>
                <td>Employer Name:</td>
                <td><input type="text" name="emp_name" required></td>
            </tr>
            <tr>
                <td>Company Name:</td>
                <td><input type="text" name="company_name" required></td>
            </tr>
            <tr>
                <td>Contact No:</td>
                <td><input type="text" name="contact_no" required></td>
            </tr>
            <tr>
                <td>User Name:</td>
                <td><input type="text" name="user_name" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="register_employer" value="Register Employer">
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>
    
    <br>
    <a href="admin.php">Back to Admin Panel</a>
</body>
</html>
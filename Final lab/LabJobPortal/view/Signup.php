
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
        <form action="../controller/signUpCheck.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Signup</legend>
                
                <?php if(isset($_GET['error'])): ?>
                    <?php if($_GET['error'] == 'null'): ?>
                        <p style="color: red;">Username, Password and Email cannot be empty!</p>
                    <?php elseif($_GET['error'] == 'dberror'): ?>
                        <p style="color: red;">Database error! Please try again.</p>
                    <?php endif; ?>
                <?php endif; ?>
                
                username: <input type="text" name="username" value="" /> <br>
                password: <input type="password" name="password" value="" /> <br>
                email: <input type="email" name="email" value="" /> <br>
                     <input type="submit" name="submit" value="Submit" />
                     <a href='login.php'>login</a>
            </fieldset>
        </form>
</body>
</html>
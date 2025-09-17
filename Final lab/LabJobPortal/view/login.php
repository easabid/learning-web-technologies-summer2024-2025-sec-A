<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
        <form action="../controller/loginCheck.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Signin</legend>
                
                <?php if(isset($_GET['error'])): ?>
                    <?php if($_GET['error'] == 'null'): ?>
                        <p style="color: red;">Username and Password cannot be empty!</p>
                    <?php elseif($_GET['error'] == 'invalid'): ?>
                        <p style="color: red;">Invalid username or password!</p>
                    <?php endif; ?>
                <?php endif; ?>
                
                username: <input type="text" name="username" value="" /> <br>
                password: <input type="password" name="password" value="" /> <br>
                     <input type="submit" name="submit" value="Submit" />
                     <a href='signup.php'>Signup</a>
            </fieldset>
        </form>

</body>
</html>
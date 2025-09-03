<?php
session_start();

$error = "";
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'null':
            $error = "⚠️ All fields are required!";
            break;
        case 'invalid':
            $error = "❌ Invalid username or password!";
            break;
        case 'unauthorized':
            $error = "⚠️ Please login first!";
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            position: fixed;
            width: 100%;
            height: 100%;
        }

        h2 {
            text-align: center;
            position: fixed;
            width: 100%;
            top: 50px;
            margin: 0;
            font-size: 24px;
        }

        form {
            position: fixed;
            width: 400px;
            height: 380px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 20px;
            box-sizing: border-box;
        }

        input[type="text"],
        input[type="password"] {
            width: 360px;
            height: 35px;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 4px;
            border: 1px solid #aaa;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 360px;
            height: 40px;
            margin-top: 15px;
            border: none;
            border-radius: 4px;
            background-color: #2563eb;
            color: white;
            cursor: pointer;
            font-size: 16px;
            position: relative;
        }

        input[type="submit"]:hover {
            background-color: #1d4ed8;
        }

        input[type="checkbox"] {
            margin-top: 10px;
        }

        label {
            font-size: 14px;
        }

        p {
            color: red;
            margin: 2px 0 6px 0;
            font-size: 13px;
            width: 360px;
        }

        .links {
            position: absolute;
            bottom: 20px;
            width: 360px;
            text-align: center;
        }

        .links p {
            color: #333;
            font-size: 14px;
        }

        .links a {
            color: #2563eb;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .error {
            position: fixed;
            width: 100%;
            text-align: center;
            color: red;
            top: 100px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <h2>Sign-In</h2>

    <?php if ($error !== ""): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form id="loginForm" action="../controllers/loginCheck.php" method="post" onsubmit="return validateLogin()">
        Username:
        <input type="text" id="username" name="username"
               value="<?= isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : '' ?>">
        <p id="usernameError"></p>

        Password:
        <input type="password" id="password" name="password">
        <p id="passwordError"></p>

        <div style="margin: 10px 0;">
            <input type="checkbox" id="remember" name="remember" <?= isset($_COOKIE['username']) ? 'checked' : '' ?>>
            <label for="remember">Remember Me</label>
        </div>

        <input type="submit" value="Login">

        <div class="links">
            <p>Don’t have an account? <a href="register.php">Register here</a></p>
        </div>
    </form>

    <script>
        function validateLogin() {
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();

            let valid = true;

            document.getElementById("usernameError").textContent = "";
            document.getElementById("passwordError").textContent = "";

            if (username === "") {
                document.getElementById("usernameError").textContent = "Username is required.";
                valid = false;
            }

            if (password === "") {
                document.getElementById("passwordError").textContent = "Password is required.";
                valid = false;
            }

            return valid;
        }
    </script>

</body>
</html>

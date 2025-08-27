<?php
session_start();

// --- Hardcoded users ---
$users = [
    "admin"    => ["password" => "admin123", "role" => "admin"],
    "employer" => ["password" => "employer123", "role" => "employer"],
    "jobseeker"=> ["password" => "job123", "role" => "jobseeker"]
];

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === "" || $password === "") {
        $error = "⚠️ All fields are required!";
    } elseif (isset($users[$username]) && $users[$username]['password'] === $password) {
        // Store in session
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $users[$username]['role'];

        // Store in cookies (for 1 day)
        setcookie("username", $username, time() + 86400, "/");
        setcookie("password", $password, time() + 86400, "/");

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "❌ Invalid username or password!";
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
            margin: 40px;
            background-color: #f3f4f6;
        }

        h2 {
            text-align: center;
        }

        form {
            width: 400px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 4px;
            border: 1px solid #aaa;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 15px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            background-color: #2563eb;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #1d4ed8;
        }

        p {
            color: red;
            margin: 2px 0 6px 0;
            font-size: 13px;
        }

        .links {
            margin-top: 10px;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Login Form</h2>

    <?php if ($error !== ""): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form id="loginForm" method="post" onsubmit="return validateLogin()">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"
               value="<?= isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : '' ?>">
        <p id="usernameError"></p>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password"
               value="<?= isset($_COOKIE['password']) ? htmlspecialchars($_COOKIE['password']) : '' ?>">
        <p id="passwordError"></p>

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

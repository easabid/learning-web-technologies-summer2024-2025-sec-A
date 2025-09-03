<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Page</title>
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
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 4px;
            border: 1px solid #aaa;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
            margin-bottom: 4px;
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

        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Register Form</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="success">
            <?php
            switch ($_GET['error']) {
                case "success":
                    echo "✅ Registration successful! Please login.";
                    break;
                case "user_exists":
                    echo "⚠️ Username already exists!";
                    break;
                case "email_exists":
                    echo "⚠️ Email already exists!";
                    break;
                case "password_mismatch":
                    echo "⚠️ Passwords do not match!";
                    break;
                case "invalid_email":
                    echo "⚠️ Invalid email format!";
                    break;
                case "null":
                    echo "⚠️ All fields are required!";
                    break;
                default:
                    echo "⚠️ Something went wrong!";
            }
            ?>
        </p>
    <?php endif; ?>

    <form id="registerForm" action="../controllers/registerCheck.php" method="post" onsubmit="return validateRegister()">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <p id="usernameError"></p>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <p id="emailError"></p>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <p id="passwordError"></p>

        <label for="confirmpassword">Confirm Password:</label>
        <input type="password" id="confirmpassword" name="confirmpassword">
        <p id="confirmError"></p>

        <label for="role">Select Role:</label>
        <select id="role" name="role">
            <option value="">Select</option>
            <option value="admin">Admin</option>
            <option value="employer">Employer</option>
            <option value="jobseeker">Job Seeker</option>
        </select>
        <p id="roleError"></p>

        <input type="submit" value="Register">

        <div class="links">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </form>

    <script>
        function validateRegister() {
            const username = document.getElementById("username").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const confirmpass = document.getElementById("confirmpassword").value.trim();
            const role = document.getElementById("role").value;

            let valid = true;

            document.getElementById("usernameError").textContent = "";
            document.getElementById("emailError").textContent = "";
            document.getElementById("passwordError").textContent = "";
            document.getElementById("confirmError").textContent = "";
            document.getElementById("roleError").textContent = "";

            if (username === "") {
                document.getElementById("usernameError").textContent = "Username is required.";
                valid = false;
            }

            if (email === "") {
                document.getElementById("emailError").textContent = "Email is required.";
                valid = false;
            } else if (email.indexOf('@') === -1 || email.indexOf('.') === -1) {
                document.getElementById("emailError").textContent = "Email must contain '@' and '.'.";
                valid = false;
            } else if (email.startsWith('@') || email.startsWith('.') || email.endsWith('@') || email.endsWith('.')) {
                document.getElementById("emailError").textContent = "Email cannot start or end with '@' or '.'.";
                valid = false;
            } else if (email.indexOf('.') < email.indexOf('@')) {
                document.getElementById("emailError").textContent = "'.' should come after '@'.";
                valid = false;
            }

            if (password === "") {
                document.getElementById("passwordError").textContent = "Password is required.";
                valid = false;
            } else if (password.length < 5) {
                document.getElementById("passwordError").textContent = "Password must be at least 5 characters long.";
                valid = false;
            } else {
                let hasSymbol = false;
                for (let i = 0; i < password.length; i++) {
                    let ch = password[i];
                    if (!(ch >= 'a' && ch <= 'z') && !(ch >= 'A' && ch <= 'Z') && !(ch >= '0' && ch <= '9')) {
                        hasSymbol = true;
                        break;
                    }
                }

                if (!hasSymbol) {
                    document.getElementById("passwordError").textContent = "Password must contain at least one symbol.";
                    valid = false;
                }
            }

            if (confirmpass === "") {
                document.getElementById("confirmError").textContent = "Confirm password is required.";
                valid = false;
            } else if (password !== confirmpass) {
                document.getElementById("confirmError").textContent = "Passwords do not match.";
                valid = false;
            }

            if (role === "") {
                document.getElementById("roleError").textContent = "Please select a role.";
                valid = false;
            }

            return valid;
        }
    </script>

</body>
</html>

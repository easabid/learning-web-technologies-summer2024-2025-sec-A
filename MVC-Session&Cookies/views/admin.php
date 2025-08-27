<?php
session_start();

// redirect if not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

$successMsg = "";
$errorMsg = "";

// --- Handle Add User Form Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addUser'])) {
    $newUsername = trim($_POST['newUsername']);
    $newRole = trim($_POST['newRole']);

    if ($newUsername === "" || $newRole === "") {
        $errorMsg = "⚠️ Both fields are required!";
    } else {
        // In real case save to DB, here just simulate success
        $successMsg = "✅ User '$newUsername' with role '$newRole' added successfully!";
    }
}

// --- Handle Logout ---
if (isset($_GET['logout'])) {
    session_destroy();
    setcookie("username", "", time() - 3600, "/");
    setcookie("password", "", time() - 3600, "/");
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= ucfirst($role) ?> Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f3f4f6;
        }
        .header {
            background-color: #2563eb;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .header h2 {
            margin: 0;
        }
        .logout-btn {
            padding: 6px 12px;
            border: none;
            margin-right: 30px;
            border-radius: 4px;
            background-color: #ef4444;
            color: white;
            cursor: pointer;
        }
        .sidebar {
            width: 220px;
            background-color: #1e293b;
            height: 100vh;
            position: fixed;
            top: 60px; 
            left: 0;
            padding-top: 20px;
            color: white;
        }
        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }
        .sidebar ul li {
            padding: 12px 20px;
            cursor: pointer;
        }
        .sidebar ul li:hover {
            background-color: #334155;
        }
        .main {
            margin-left: 220px;
            padding: 80px 20px 20px; 
        }
        .card {
            display: inline-block;
            width: 200px;
            margin: 10px;
            padding: 15px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 0 6px #ccc;
            text-align: center;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card h3 {
            margin: 10px 0;
            font-size: 22px;
            color: #2563eb;
        }
        .card p {
            margin: 0;
            color: #4b5563;
        }
        p[id$="Error"], .error {
            color: red;
            font-size: 14px;
            margin: 4px 0;
        }
        .success {
            color: green;
            font-size: 14px;
        }
        
        @media screen and (max-width: 600px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding-top: 10px;
            }
            .main {
                margin-left: 0;
                padding: 100px 10px 20px;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h2><?= ucfirst($role) ?> Dashboard - Welcome, <?= htmlspecialchars($username) ?></h2>
    <button class="logout-btn" onclick="window.location.href='?logout=true'">Logout</button>
</div>

<div class="sidebar">
    <ul>
        <li onclick="showSection('overview')">Overview</li>
        <li onclick="showSection('manageUsers')">Manage Users</li>
        <li onclick="showSection('reports')">Reports</li>
    </ul>
</div>

<div class="main">
    <div id="overview">
        <h3>Overview</h3>
        <div class="card">
            <h3>10</h3>
            <p>Total Users</p>
        </div>
        <div class="card">
            <h3>5</h3>
            <p>Active Employers</p>
        </div>
        <div class="card">
            <h3>20</h3>
            <p>Job Listings</p>
        </div>
        <div class="card">
            <h3>15</h3>
            <p>Applications</p>
        </div>
    </div>

    <div id="manageUsers" style="display:none;">
        <h3>Manage Users</h3>

        <?php if ($errorMsg): ?>
            <p class="error"><?= $errorMsg ?></p>
        <?php endif; ?>

        <?php if ($successMsg): ?>
            <p class="success"><?= $successMsg ?></p>
        <?php endif; ?>

        <form id="addUserForm" method="post" onsubmit="return validateAddUser()">
            <label for="newUsername">Username:</label><br>
            <input type="text" id="newUsername" name="newUsername"><br>
            <p id="usernameError"></p>

            <label for="newRole">Role:</label><br>
            <select id="newRole" name="newRole">
                <option value="">--Select--</option>
                <option value="admin">Admin</option>
                <option value="employer">Employer</option>
                <option value="jobseeker">Job Seeker</option>
            </select><br>
            <p id="roleError"></p>

            <input type="submit" name="addUser" value="Add User">
        </form>
    </div>

    <div id="reports" style="display:none;">
        <h3>Reports</h3>
        <p>View system statistics and reports here.</p>
        <ul>
            <li>Total Users: 10</li>
            <li>Jobs Posted: 20</li>
            <li>Applications: 15</li>
        </ul>
    </div>
</div>

<script>
function showSection(section) {
    document.getElementById('overview').style.display = 'none';
    document.getElementById('manageUsers').style.display = 'none';
    document.getElementById('reports').style.display = 'none';
    document.getElementById(section).style.display = 'block';
}

function validateAddUser() {
    const username = document.getElementById('newUsername').value.trim();
    const role = document.getElementById('newRole').value;

    let valid = true;
    document.getElementById('usernameError').textContent = "";
    document.getElementById('roleError').textContent = "";

    if (username === "") {
        document.getElementById('usernameError').textContent = "Username is required.";
        valid = false;
    }
    if (role === "") {
        document.getElementById('roleError').textContent = "Role must be selected.";
        valid = false;
    }

    return valid;
}
</script>

</body>
</html>

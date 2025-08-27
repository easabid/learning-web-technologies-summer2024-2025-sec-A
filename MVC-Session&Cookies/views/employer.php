<?php
// employer_dashboard.php
session_start();

// --- Check if employer is logged in ---
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit();
}

// Hardcoded job storage (temporary, resets on reload)
if (!isset($_SESSION['jobs'])) {
    $_SESSION['jobs'] = [
        ["title" => "Web Developer", "location" => "Dhaka", "salary" => "30000"]
    ];
}

// --- Handle Job Posting (Server-side validation) ---
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postJob'])) {
    $title = trim($_POST['jobTitle']);
    $location = trim($_POST['jobLocation']);
    $salary = trim($_POST['jobSalary']);

    if ($title === "" || $location === "" || $salary === "") {
        $error = "All fields are required.";
    } else {
        $_SESSION['jobs'][] = [
            "title" => $title,
            "location" => $location,
            "salary" => $salary
        ];
    }
}

// --- Handle Job Deletion ---
if (isset($_GET['delete'])) {
    $index = (int) $_GET['delete'];
    if (isset($_SESSION['jobs'][$index])) {
        unset($_SESSION['jobs'][$index]);
        $_SESSION['jobs'] = array_values($_SESSION['jobs']); // reindex
    }
    header("Location: employer_dashboard.php");
    exit();
}

// --- Handle Logout ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employer Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f3f4f6; }
        .header { background-color: #2563eb; color: white; padding: 15px 20px;
                  display: flex; justify-content: space-between; align-items: center;
                  position: fixed; top: 0; left: 0; width: 100%; z-index: 1000; }
        .header h2 { margin: 0; }
        .logout-btn { padding: 6px 12px; border: none; margin-right: 30px; border-radius: 4px;
                      background-color: #ef4444; color: white; cursor: pointer; }
        .sidebar { width: 220px; background-color: #1e293b; height: 100vh;
                   position: fixed; top: 60px; left: 0; padding-top: 20px; color: white; }
        .sidebar ul { list-style: none; padding-left: 0; }
        .sidebar ul li { padding: 12px 20px; cursor: pointer; }
        .sidebar ul li:hover { background-color: #334155; }
        .main { margin-left: 220px; padding: 80px 20px 20px; }
        table { width: 100%; border-collapse: collapse; background-color: white; box-shadow: 0 0 6px #ccc; margin-top: 15px; }
        table th, table td { padding: 8px 12px; border: 1px solid #ddd; }
        table th { background-color: #e2e8f0; }
        .btn { padding: 4px 8px; border: none; border-radius: 4px; background-color: #2563eb; color: white; cursor: pointer; }
        .btn:hover { background-color: #1d4ed8; }
        .card { display: inline-block; width: 200px; margin: 10px; padding: 15px; background-color: white;
                border-radius: 6px; box-shadow: 0 0 6px #ccc; text-align: center; transition: transform 0.2s; }
        .card:hover { transform: scale(1.05); }
        .card h3 { margin: 10px 0; font-size: 22px; color: #2563eb; }
        .card p { margin: 0; color: #4b5563; }
        .error { color: red; margin: 5px 0; }
    </style>
</head>
<body>

<div class="header">
    <h2>Employer Dashboard</h2>
    <a href="?logout=true"><button class="logout-btn">Logout</button></a>
</div>

<div class="sidebar">
    <ul>
        <li onclick="showSection('overview')">Overview</li>
        <li onclick="showSection('postJob')">Post Job</li>
        <li onclick="showSection('manageJobs')">Manage Jobs</li>
    </ul>
</div>

<div class="main">
    <!-- Overview -->
    <div id="overview">
        <h3>Overview</h3>
        <div class="card">
            <h3><?php echo count($_SESSION['jobs']); ?></h3>
            <p>Active Jobs</p>
        </div>
        <div class="card">
            <h3>12</h3>
            <p>Applications</p>
        </div>
    </div>

    <!-- Post Job -->
    <div id="postJob" style="display:none;">
        <h3>Post a New Job</h3>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form id="postJobForm" method="POST" onsubmit="return validateJobForm()">
            <label for="jobTitle">Job Title:</label><br>
            <input type="text" id="jobTitle" name="jobTitle"><br>
            <p id="jobTitleError" class="error"></p>

            <label for="jobLocation">Location:</label><br>
            <input type="text" id="jobLocation" name="jobLocation"><br>
            <p id="jobLocationError" class="error"></p>

            <label for="jobSalary">Salary:</label><br>
            <input type="number" id="jobSalary" name="jobSalary"><br>
            <p id="jobSalaryError" class="error"></p>

            <input type="submit" name="postJob" value="Post Job" class="btn">
        </form>
    </div>

    <!-- Manage Jobs -->
    <div id="manageJobs" style="display:none;">
        <h3>Manage Jobs</h3>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['jobs'] as $index => $job): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($job['title']); ?></td>
                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                        <td><?php echo htmlspecialchars($job['salary']); ?></td>
                        <td><a href="?delete=<?php echo $index; ?>"><button class="btn">Delete</button></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function showSection(section) {
    document.getElementById('overview').style.display = 'none';
    document.getElementById('postJob').style.display = 'none';
    document.getElementById('manageJobs').style.display = 'none';
    document.getElementById(section).style.display = 'block';
}

function validateJobForm() {
    const title = document.getElementById('jobTitle').value.trim();
    const location = document.getElementById('jobLocation').value.trim();
    const salary = document.getElementById('jobSalary').value.trim();

    let valid = true;
    document.getElementById('jobTitleError').textContent = "";
    document.getElementById('jobLocationError').textContent = "";
    document.getElementById('jobSalaryError').textContent = "";

    if (title === "") {
        document.getElementById('jobTitleError').textContent = "Job title is required.";
        valid = false;
    }
    if (location === "") {
        document.getElementById('jobLocationError').textContent = "Location is required.";
        valid = false;
    }
    if (salary === "") {
        document.getElementById('jobSalaryError').textContent = "Salary is required.";
        valid = false;
    }

    return valid; // allow submit only if valid
}
</script>

</body>
</html>

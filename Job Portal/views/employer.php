<?php
require_once '../controllers/sessionCheck.php';
if ($_SESSION['role'] !== 'employer') {
    header("Location: login.php?error=unauthorized");
    exit;
}

if (!isset($_SESSION['jobs'])) {
    $_SESSION['jobs'] = [
        ["title" => "Web Developer", "location" => "Dhaka", "salary" => "30000"]
    ];
}

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

if (isset($_GET['delete'])) {
    $index = (int) $_GET['delete'];
    if (isset($_SESSION['jobs'][$index])) {
        unset($_SESSION['jobs'][$index]);
        $_SESSION['jobs'] = array_values($_SESSION['jobs']); // reindex
    }
    header("Location: employer.php");
    exit();
}

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

        /* Post Job Styles */
        .post-job-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .job-form {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #374151;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37,99,235,0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .submit-btn:hover {
            background-color: #1d4ed8;
        }

        /* Recent Posts Styles */
        .recent-posts {
            margin-top: 40px;
        }

        .recent-posts h3 {
            margin-bottom: 20px;
            color: #374151;
        }

        .job-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .job-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .job-card:hover {
            transform: translateY(-5px);
        }

        .job-card h4 {
            margin: 0 0 15px 0;
            color: #1e40af;
            font-size: 18px;
        }

        .job-card p {
            margin: 8px 0;
            color: #4b5563;
            font-size: 14px;
        }

        .job-location, .job-salary, .job-date {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .job-tags {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .job-tags span {
            background: #e5e7eb;
            color: #374151;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        /* Notification Styles */
        .notification-list {
            max-width: 800px;
        }

        .notification-item {
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            border-left: 4px solid #cbd5e1;
        }

        .notification-item.unread {
            border-left-color: #2563eb;
            background-color: #f8fafc;
        }

        .notification-item h4 {
            margin: 0 0 10px 0;
            color: #1e293b;
            font-size: 16px;
        }

        .notification-item p {
            margin: 0 0 15px 0;
            color: #64748b;
        }

        .notification-time {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #94a3b8;
            font-size: 12px;
        }

        .notification-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
            color: white;
        }

        .badge-success { background-color: #22c55e; }
        .badge-warning { background-color: #eab308; }
        .badge-info { background-color: #3b82f6; }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            background-color: #2563eb;
            color: white;
            cursor: pointer;
            margin-right: 10px;
            font-size: 12px;
        }

        .action-btn:hover {
            background-color: #1d4ed8;
        }

        .action-btn.view {
            background-color: #22c55e;
        }

        .action-btn.view:hover {
            background-color: #16a34a;
        }
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
        <li onclick="showSection('notifications')">Notifications</li>
    </ul>
</div>

<div class="main">
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
        <div class="card">
            <h3>5</h3>
            <p>Interviews Scheduled</p>
        </div>
        <div class="card">
            <h3>8</h3>
            <p>Profile Views</p>
        </div>
    </div>

    <div id="postJob" style="display:none;">
        <h3>Post a New Job</h3>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <div class="post-job-container">
            <form id="postJobForm" method="POST" onsubmit="return validateJobForm()" class="job-form">
                <div class="form-group">
                    <label for="jobTitle">Job Title:</label>
                    <input type="text" id="jobTitle" name="jobTitle" placeholder="e.g., Senior Web Developer">
                    <p id="jobTitleError" class="error"></p>
                </div>

                <div class="form-group">
                    <label for="jobLocation">Location:</label>
                    <input type="text" id="jobLocation" name="jobLocation" placeholder="e.g., Dhaka, Bangladesh">
                    <p id="jobLocationError" class="error"></p>
                </div>

                <div class="form-group">
                    <label for="jobSalary">Monthly Salary (BDT):</label>
                    <input type="number" id="jobSalary" name="jobSalary" placeholder="e.g., 50000">
                    <p id="jobSalaryError" class="error"></p>
                </div>

                <button type="submit" name="postJob" class="submit-btn">Post New Job</button>
            </form>
        </div>

        <div class="recent-posts">
            <h3>Recently Posted Jobs</h3>
            <div class="job-cards">
                <div class="job-card">
                    <h4>Senior Frontend Developer</h4>
                    <p class="job-location">🏢 Dhaka, Bangladesh</p>
                    <p class="job-salary">💰 BDT 80,000 - 100,000</p>
                    <p class="job-date">📅 Posted: Today</p>
                    <div class="job-tags">
                        <span>React</span>
                        <span>TypeScript</span>
                        <span>5 Years</span>
                    </div>
                </div>

                <div class="job-card">
                    <h4>Backend Developer</h4>
                    <p class="job-location">🏢 Chittagong, Bangladesh</p>
                    <p class="job-salary">💰 BDT 60,000 - 80,000</p>
                    <p class="job-date">📅 Posted: 1 day ago</p>
                    <div class="job-tags">
                        <span>PHP</span>
                        <span>Laravel</span>
                        <span>3 Years</span>
                    </div>
                </div>

                <div class="job-card">
                    <h4>UI/UX Designer</h4>
                    <p class="job-location">🏢 Dhaka, Bangladesh</p>
                    <p class="job-salary">💰 BDT 45,000 - 65,000</p>
                    <p class="job-date">📅 Posted: 2 days ago</p>
                    <div class="job-tags">
                        <span>Figma</span>
                        <span>Adobe XD</span>
                        <span>2 Years</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <div id="notifications" style="display:none;">
        <h3>Notifications</h3>
        <div class="notification-list">
            <div class="notification-item unread">
                <span class="notification-time">5 minutes ago</span>
                <h4>New Job Application<span class="notification-badge badge-info">New</span></h4>
                <p>E.A. Sabid applied for "Web Developer"</p>
                <button class="action-btn view">View Application</button>
            </div>

            <div class="notification-item unread">
                <span class="notification-time">2 hours ago</span>
                <h4>Application Status Update<span class="notification-badge badge-success">Accepted</span></h4>
                <p>Sabid accepted your job - "Senior UI Designer"</p>
                <button class="action-btn">Send Email</button>
            </div>

            <div class="notification-item">
                <span class="notification-time">2 days ago</span>
                <h4>Interview Schedule</h4>
                <p>Reminder: Virtual interview scheduled with Naim for "Python Developer" tomorrow at 2 PM</p>
                <button class="action-btn">Join Meeting</button>
                <button class="action-btn">Reschedule</button>
            </div>
        </div>
    </div>
</div>

<script>
function showSection(section) {
    document.getElementById('overview').style.display = 'none';
    document.getElementById('postJob').style.display = 'none';
    document.getElementById('manageJobs').style.display = 'none';
    document.getElementById('notifications').style.display = 'none';
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

    return valid; 
}
</script>

</body>
</html>

<?php
require_once '../controllers/sessionCheck.php';
if ($_SESSION['role'] !== 'jobseeker') {
    header("Location: login.php?error=unauthorized");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Seeker Dashboard</title>
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
            margin-right: 30px; /* move left */
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
            top: 60px; /* below header */
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
            padding: 80px 20px 20px; /* extra padding for fixed header */
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background-color: white;
            box-shadow: 0 0 6px #ccc;
        }
        table th, table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #e2e8f0;
        }
        .btn-apply {
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            background-color: #2563eb;
            color: white;
            cursor: pointer;
        }
        .btn-apply:hover {
            background-color: #1d4ed8;
        }
        .notification {
            background-color: white;
            padding: 10px;
            margin: 5px 0;
            border-radius: 4px;
            box-shadow: 0 0 3px #ccc;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Job Seeker Dashboard</h2>
    <form method="post" action="../controllers/logout.php">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>

<div class="sidebar">
    <ul>
        <li onclick="showSection('overview')">Overview</li>
        <li onclick="showSection('browseJobs')">Browse Jobs</li>
        <li onclick="showSection('appliedJobs')">My Applications</li>
        <li onclick="showSection('notifications')">Notifications</li>
    </ul>
</div>

<div class="main">
    <div id="overview">
        <h3>Overview</h3>
        <div class="card">
            <h3 id="appliedCount">3</h3>
            <p>Total Jobs Applied</p>
        </div>
        <div class="card">
            <h3 id="availableCount">3</h3>
            <p>Available Jobs</p>
        </div>
        <div class="card">
            <h3 id="notificationCount">4</h3>
            <p>Notifications</p>
        </div>
    </div>

    <div id="browseJobs" style="display:none;">
        <h3>Browse Jobs</h3>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="jobTable">
                <tr>
                    <td>Web Developer</td>
                    <td>Algotech</td>
                    <td>Dhaka</td>
                    <td>30000</td>
                    <td><button class="btn-apply" onclick="applyJob(this)">Apply</button></td>
                </tr>
                <tr>
                    <td>Graphic Designer</td>
                    <td>Hollyeood</td>
                    <td>Kuril</td>
                    <td>25000</td>
                    <td><button class="btn-apply" onclick="applyJob(this)">Apply</button></td>
                </tr>
                <tr>
                    <td>Content Writer</td>
                    <td>Star Jolsa</td>
                    <td>Dhaka</td>
                    <td>20000</td>
                    <td><button class="btn-apply" onclick="applyJob(this)">Apply</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="appliedJobs" style="display:none;">
        <h3>My Applications</h3>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="appliedTable">
                <tr>
                    <td>Senior Web Developer</td>
                    <td>Tech Solutions Ltd</td>
                    <td>Dhaka</td>
                    <td>45000</td>
                    <td>Under Review</td>
                </tr>
                <tr>
                    <td>UI/UX Designer</td>
                    <td>Creative Studio</td>
                    <td>Chittagong</td>
                    <td>35000</td>
                    <td>Shortlisted</td>
                </tr>
                <tr>
                    <td>Frontend Developer</td>
                    <td>WebTech BD</td>
                    <td>Dhaka</td>
                    <td>40000</td>
                    <td>Rejected</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="notifications" style="display:none;">
        <h3>Notifications</h3>
        <div id="notificationList">
            <div class="notification">
                <strong>Application Update:</strong> You have select for UI/UX Designer position at AlgoTech.
                <small style="display:block;color:#666;margin-top:5px;">2 hours ago</small>
            </div>
            <div class="notification">
                <strong>Application Status:</strong> Your application for Frontend Developer at WebTech BD was not selected.
                <small style="display:block;color:#666;margin-top:5px;">1 day ago</small>
            </div>
            <div class="notification">
                <strong>New Job Match:</strong> A new Senior WEB Developer position matches your profile.
                <small style="display:block;color:#666;margin-top:5px;">2 days ago</small>
            </div>
            <div class="notification">
                <strong>Application Received:</strong> Your application for Senior Web Developer is received.
                <small style="display:block;color:#666;margin-top:5px;">3 days ago</small>
            </div>
        </div>
    </div>
</div>

<script>
function showSection(section) {
    document.getElementById('overview').style.display = 'none';
    document.getElementById('browseJobs').style.display = 'none';
    document.getElementById('appliedJobs').style.display = 'none';
    document.getElementById('notifications').style.display = 'none';
    document.getElementById(section).style.display = 'block';
}

function applyJob(btn) {
    const row = btn.parentElement.parentElement;
    const title = row.cells[0].innerText;
    const employer = row.cells[1].innerText;
    const location = row.cells[2].innerText;
    const salary = row.cells[3].innerText;

    btn.disabled = true;
    btn.innerText = "Applied";

    const appliedTable = document.getElementById('appliedTable');
    if(appliedTable.children.length === 1 && appliedTable.children[0].children[0].colSpan === 5){
        appliedTable.innerHTML = "";
    }
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${title}</td><td>${employer}</td><td>${location}</td><td>${salary}</td><td>Under Review</td>`;
    appliedTable.appendChild(tr);

    const notif = document.getElementById('notificationList');
    if(notif.children.length === 1 && notif.children[0].tagName === 'P'){
        notif.innerHTML = "";
    }
    const p = document.createElement('div');
    p.className = "notification";
    p.innerHTML = `You applied for <strong>${title}</strong> at ${employer}.`;
    notif.prepend(p);

    document.getElementById('appliedCount').innerText = appliedTable.children.length;
    document.getElementById('notificationCount').innerText = notif.children.length;
}
</script>

</body>
</html>

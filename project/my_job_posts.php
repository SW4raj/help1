<?php
include('db_connect.php'); // DB connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all jobs from the database
$sql = "SELECT j.id, j.title, j.description, j.job_type, j.budget, j.duration, u.username 
        FROM jobs j 
        JOIN users u ON j.freelancer_id = u.id";
$result = $conn->query($sql);

// Fetch the jobs created by the logged-in freelancer
$freelancer_id = $_SESSION['user_id'];
$my_jobs_sql = "SELECT id, title, description, job_type, budget, duration FROM jobs WHERE freelancer_id = ?";
$stmt = $conn->prepare($my_jobs_sql);
$stmt->bind_param('i', $freelancer_id);
$stmt->execute();
$my_jobs_result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FAFAFA;
            margin-top: 20px;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            bottom: 0;
            width: 250px;
            background-color: #302B27;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-item.active .nav-link {
            background-color: #FF5370;
        }
        .content {
            margin-left: 250px;
        }
        .card {
            border-radius: 5px;
            box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
            border: none;
            margin-bottom: 30px;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card .card-block {
            padding: 25px;
        }
        .order-card i {
            font-size: 26px;
        }
        .f-left {
            float: left;
        }
        .f-right {
            float: right;
        }
        .bg-c-blue {
            background: linear-gradient(45deg, #4099ff, #73b4ff);
        }
        .bg-c-green {
            background: linear-gradient(45deg, #2ed8b6, #59e0c5);
        }
        .bg-c-yellow {
            background: linear-gradient(45deg, #FFB64D, #ffcb80);
        }
        .bg-c-pink {
            background: linear-gradient(45deg, #FF5370, #ff869a);
        }
        .container-fluid {
            max-width: 1200px;
        }
        .order-card {
            color: #fff;
            padding: 20px;
            border-radius: 10px;
        }
        .order-card:hover {
            transform: scale(1.05);
        }

        /* Toggle button styles */
        .toggle-btn {
            display: inline-block;
            width: 50px;
            height: 25px;
            background-color: #ddd;
            border-radius: 15px;
            position: relative;
            cursor: pointer;
        }
        .toggle-btn:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 3px;
            width: 20px;
            height: 20px;
            background-color: #fff;
            border-radius: 50%;
            transition: all 0.3s ease;
            transform: translateY(-50%);
        }
        .toggle-btn.active:before {
            left: 27px;
        }
        .toggle-btn:hover {
            background-color: #bbb;
        }
        /* Ensure toggle is off by default */
        .toggle-btn:not(.active):before {
            left: 3px;
        }

        /* Adjust card height to be the same */
        .card {
            height: 100%;
        }
        .card-body {
            flex: 1;
        }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                height: auto;
                width: 100%;
            }
            .content {
                margin-left: 0;
            }
            .sidebar .nav-item {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar sidebar-dark bg-dark">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="freelancer_dashboard.php" aria-label="Dashboard">
                    <i class="cil-speedometer" aria-hidden="true"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="create_job.php" aria-label="Create Job">
                    <i class="cil-plus" aria-hidden="true"></i> Create Job
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="jobs.php" aria-label="Job Listings">
                    <i class="cil-briefcase" aria-hidden="true"></i> Job Listings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="my_applications.php" aria-label="My Applications">
                    <i class="cil-task" aria-hidden="true"></i> My Applications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="edit_profile.php" aria-label="My Profile">
                    <i class="cil-user" aria-hidden="true"></i> My Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="my_job_posts.php" aria-label="My Job Posts">
                    <i class="cil-folder" aria-hidden="true"></i> My Job Posts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="notifications.php" aria-label="Notifications">
                    <i class="cil-bell" aria-hidden="true"></i> Notifications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="logout.php" aria-label="Logout">
                    <i class="cil-account-logout" aria-hidden="true"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <div class="container">
        <h2>Job Listings</h2>
        
        <h3>Your Jobs</h3>
        <ul class="list-group mb-4">
            <?php while ($job = $my_jobs_result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <h5><?= $job['title'] ?></h5>
                    <p><?= $job['description'] ?></p>
                    <small>Type: <?= $job['job_type'] ?> | Budget: $<?= $job['budget'] ?> | Duration: <?= $job['duration'] ?></small>
                    <a href="edit_job.php?id=<?= $job['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_job.php?id=<?= $job['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>

        <h3>All Available Jobs</h3>
        <ul class="list-group">
            <?php while ($job = $result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <h5><?= $job['title'] ?></h5>
                    <p><?= $job['description'] ?></p>
                    <small>Posted by: <?= $job['username'] ?> | Type: <?= $job['job_type'] ?> | Budget: $<?= $job['budget'] ?> | Duration: <?= $job['duration'] ?></small>
                    <a href="apply_job.php?id=<?= $job['id'] ?>" class="btn btn-primary btn-sm">Apply</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>

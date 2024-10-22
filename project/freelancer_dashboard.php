<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/coreui@4.1.0/dist/css/coreui.min.css" rel="stylesheet">
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
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar sidebar-dark bg-dark">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="freelancer_dashboard.php" aria-label="Dashboard">
                        <i class="cil-speedometer" aria-hidden="true"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create_job.php" aria-label="Create Job">
                        <i class="cil-plus" aria-hidden="true"></i> Create Job
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="jobs.php" aria-label="Job Listings">
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

        <!-- Main Content -->
        <div class="content p-4">
            <div class="container-fluid">
                <!-- Profile Completeness Progress Bar -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Profile Completeness</h5>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: 100%;" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row for Cards -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-c-blue">
                            <div class="card-block">
                                <h4 class="card-title">Job Applications</h4>
                                <p class="card-text">You have 5 new job applications to review.</p>
                                <a href="my_applications.php" class="btn btn-light">View Applications</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-c-green">
                            <div class="card-block">
                                <h4 class="card-title">Active Job Posts</h4>
                                <p class="card-text">You currently have 3 active job postings.</p>
                                <a href="my_job_posts.php" class="btn btn-light">Manage Posts</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-c-yellow">
                            <div class="card-block">
                                <h4 class="card-title">Profile Status</h4>
                                <p class="card-text">Your profile is 100% complete.</p>
                                <a href="edit_profile.php" class="btn btn-light">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading Spinner for Job Listings -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                Recent Job Listings
                            </div>
                            <div class="card-body">
                                <div id="loading-spinner" class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>

                                <!-- Job Listings Table (loading simulated) -->
                                <table class="table table-striped d-none" id="job-listings-table">
                                    <thead>
                                        <tr>
                                            <th>Job Title</th>
                                            <th>Job Type</th>
                                            <th>Duration</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Graphic Designer</td>
                                            <td>Freelance</td>
                                            <td>3 months</td>
                                            <td><a href="#" class="btn btn-info btn-sm">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Web Developer</td>
                                            <td>Part-Time</td>
                                            <td>6 months</td>
                                            <td><a href="#" class="btn btn-info btn-sm">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>SEO Specialist</td>
                                            <td>Full-Time</td>
                                            <td>1 year</td>
                                            <td><a href="#" class="btn btn-info btn-sm">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="jobs.php" class="btn btn-primary">Browse More Jobs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to toggle button behavior on hover -->
    <script>
        const toggleBtn = document.querySelector('.toggle-btn');
        toggleBtn.addEventListener('mouseenter', function() {
            // Turn off the toggle on hover
            toggleBtn.classList.remove('active');
        });

        toggleBtn.addEventListener('click', function() {
            // Toggle the active class
            toggleBtn.classList.toggle('active');
        });

        // Simulate loading for Job Listings
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('loading-spinner').classList.add('d-none');
                document.getElementById('job-listings-table').classList.remove('d-none');
            }, 2000);  // 2 seconds
        });
    </script>

</body>
</html>

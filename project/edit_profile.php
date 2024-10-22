<?php
include('db_connect.php'); // DB connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$sql = "SELECT email, first_name, surname, mobile, address1, address2, postcode, state, area, country, education FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $first_name = $_POST['first_name'];
    $surname = $_POST['surname'];
    $mobile = $_POST['mobile'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $postcode = $_POST['postcode'];
    $state = $_POST['state'];
    $area = $_POST['area'];
    $country = $_POST['country'];
    $education = $_POST['education'];

    // Update the user's profile
    if ($password) {
        $update_sql = "UPDATE users SET email = ?, password = ?, first_name = ?, surname = ?, mobile = ?, address1 = ?, address2 = ?, postcode = ?, state = ?, area = ?, country = ?, education = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('ssssssssssssi', $email, $password, $first_name, $surname, $mobile, $address1, $address2, $postcode, $state, $area, $country, $education, $user_id);
    } else {
        $update_sql = "UPDATE users SET email = ?, first_name = ?, surname = ?, mobile = ?, address1 = ?, address2 = ?, postcode = ?, state = ?, area = ?, country = ?, education = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('sssssssssssi', $email, $first_name, $surname, $mobile, $address1, $address2, $postcode, $state, $area, $country, $education, $user_id);
    }

    if ($stmt->execute()) {
        $success_message = "Profile updated successfully.";
    } else {
        $error_message = "Failed to update profile.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile</title>
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

    <div class="content">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                        <span class="font-weight-bold"><?= $_SESSION['user_name'] ?></span>
                        <span class="text-black-50"><?= $user_data['email'] ?></span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <?php if (!empty($success_message)): ?>
                            <div class="alert alert-success"><?= $success_message ?></div>
                        <?php elseif (!empty($error_message)): ?>
                            <div class="alert alert-danger"><?= $error_message ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="labels">First Name</label>
                                    <input type="text" class="form-control" name="first_name" value="<?= $user_data['first_name'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Surname</label>
                                    <input type="text" class="form-control" name="surname" value="<?= $user_data['surname'] ?>" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= $user_data['email'] ?>" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">New Password (Leave blank if not changing)</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Mobile Number</label>
                                    <input type="text" class="form-control" name="mobile" value="<?= $user_data['mobile'] ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Address Line 1</label>
                                    <input type="text" class="form-control" name="address1" value="<?= $user_data['address1'] ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Address Line 2</label>
                                    <input type="text" class="form-control" name="address2" value="<?= $user_data['address2'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Postcode</label>
                                    <input type="text" class="form-control" name="postcode" value="<?= $user_data['postcode'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">State</label>
                                    <input type="text" class="form-control" name="state" value="<?= $user_data['state'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Area</label>
                                    <input type="text" class="form-control" name="area" value="<?= $user_data['area'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Country</label>
                                    <input type="text" class="form-control" name="country" value="<?= $user_data['country'] ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Education</label>
                                    <input type="text" class="form-control" name="education" value="<?= $user_data['education'] ?>">
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
session_start();


if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: dist_auth_log.html");
    exit;
}

// Include database configuration file
require_once "connect.php";

// Get the registration number from the URL
$reg_no = isset($_GET['reg_no']) ? $_GET['reg_no'] : '';

// Fetch the member details from the database
$sql = "SELECT * FROM members WHERE reg_no = ?";
if ($stmt = $con->prepare($sql)) {
    $stmt->bind_param("s", $reg_no);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $member = $result->fetch_assoc();

        $stmt->close();
    } else {
        echo "Execution failed: " . $stmt->error;
    }
} else {
    echo "Prepare failed: " . $con->error;
}

$con->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #3f4850;
            color: #fff;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #007bff;
            text-decoration: none;
        }
        .sidebar .sidebar-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            color: #343a40 !important;
        }
        .profile-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 35px;
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-card img {
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .profile-card h3 {
            margin-bottom: 10px;
        }
        .profile-card p {
            margin-bottom: 5px;
            color: #666;
        }
        .tabs-content {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .nav-tabs .nav-link.active {
            border-color: #dee2e6 #dee2e6 #fff;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Kerala Congress</h3>
            <p><?php echo htmlspecialchars($_SESSION["username"]); ?></p>
        </div>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="get_card.php"><i class="fas fa-id-card"></i> Get Card</a>
        <a href="#"><i class="fas fa-money-check-alt"></i> Checkout Payments</a>
        <a href="find_member.php"><i class="fas fa-users"></i> Find Members</a>
        <a href="#"><i class="fas fa-key"></i> Change Password</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Checkout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="find_member.php">Find Members</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-card">
                        <img src="<?php echo htmlspecialchars($member['photo']); ?>" alt="Profile Photo" class="img-fluid rounded-circle">
                        <h3><?php echo htmlspecialchars($member['fname'] . ' ' . $member['lname']); ?></h3>
                        <p><?php echo htmlspecialchars($member['membership']); ?></p>
                       
                    </div>
                </div>
                <div class="col-md-8">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="true">Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Tab 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Tab 3</a>
                        </li>
                    </ul>
                    <div class="tab-content tabs-content" id="myTabContent">
                        <!-- Account Tab -->
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="reg_no">Reg No</label>
                                        <input type="text" class="form-control" id="reg_no" value="<?php echo htmlspecialchars($member['reg_no']); ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="fname">First Name</label>
                                        <input type="text" class="form-control" id="fname" value="<?php echo htmlspecialchars($member['fname']); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="lname">Last Name</label>
                                        <input type="text" class="form-control" id="lname" value="<?php echo htmlspecialchars($member['lname']); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="membership">Membership</label>
                                        <input type="text" class="form-control" id="membership" value="<?php echo htmlspecialchars($member['membership']); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="aadhaar">Aadhaar</label>
                                        <input type="text" class="form-control" id="aadhaar" value="<?php echo htmlspecialchars($member['aadhaar']); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($member['email']); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" value="<?php echo htmlspecialchars($member['mobile']); ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Tab 2 -->
                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" value="<?php echo htmlspecialchars($member['address']); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="dateofbirth">Date of Birth</label>
                                        <input type="date" class="form-control" id="dateofbirth" value="<?php echo htmlspecialchars($member['dateofbirth']); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="fathername">Father's Name</label>
                                        <input type="text" class="form-control" id="fathername" value="<?php echo htmlspecialchars($member['fathername']); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="religion">Religion</label>
                                        <input type="text" class="form-control" id="religion" value="<?php echo htmlspecialchars($member['religion']); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="caste">Caste</label>
                                        <input type="text" class="form-control" id="caste" value="<?php echo htmlspecialchars($member['caste']); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gender">Gender</label>
                                        <input type="text" class="form-control" id="gender" value="<?php echo htmlspecialchars($member['gender']); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="blood">Blood Group</label>
                                        <input type="text" class="form-control" id="blood" value="<?php echo htmlspecialchars($member['blood']); ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Tab 3 -->
                        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="district">District</label>
                                        <input type="text" class="form-control" id="district" value="<?php echo htmlspecialchars($member['district']); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="assembly">Assembly</label>
                                        <input type="text" class="form-control" id="assembly" value="<?php echo htmlspecialchars($member['assembly']); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="selfgovt">Local Self Government</label>
                                        <input type="text" class="form-control" id="selfgovt" value="<?php echo htmlspecialchars($member['selfgovt']); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ward">Ward</label>
                                        <input type="text" class="form-control" id="ward" value="<?php echo htmlspecialchars($member['ward']); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="reference">Reference</label>
                                        <input type="text" class="form-control" id="reference" value="<?php echo htmlspecialchars($member['reference']); ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

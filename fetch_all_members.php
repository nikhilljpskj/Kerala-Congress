

<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: dist_auth_log.html");
    exit;
}

// Include database configuration file
require_once "connect.php";

// Get the membership type from the URL
$membership = isset($_GET['membership']) ? $_GET['membership'] : '';

$district = $_SESSION['district'];

$sql = "SELECT reg_no, fname, lname, mobile, aadhaar, gender, assembly, selfgovt, photo 
        FROM members 
        WHERE membership = ? AND district = ? AND status = 1";

// Prepare the SQL statement
if ($stmt = $con->prepare($sql)) {
    // Bind parameters
    $stmt->bind_param("ss", $membership, $district);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Get result set
        $result = $stmt->get_result();
        
        // Fetch data
        $members = $result->fetch_all(MYSQLI_ASSOC);
        
        // Close statement
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
    <title>New Members - <?php echo htmlspecialchars($membership); ?></title>
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
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .table-container {
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle !important;
        }
        .photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
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
        <div class="container table-container">
            <h2>New Members - <?php echo htmlspecialchars($membership); ?></h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Reg No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Aadhaar</th>
                        <th>Assembly</th>
                        <th>Local Self</th>
                        <th>Photo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($members)): ?>
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member['reg_no']); ?></td>
                                <td><?php echo htmlspecialchars($member['fname'] . ' ' . $member['lname']); ?></td>
                                <td><?php echo htmlspecialchars($member['mobile']); ?></td>
                                <td><?php echo htmlspecialchars($member['gender']); ?></td>
                                <td><?php echo htmlspecialchars($member['aadhaar']); ?></td>
                                <td><?php echo htmlspecialchars($member['assembly']); ?></td>
                                <td><?php echo htmlspecialchars($member['selfgovt']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($member['photo']); ?>" class="photo" alt="Photo"></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No new members found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

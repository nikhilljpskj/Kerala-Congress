<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: dist_auth_log.html");
    exit;
}

// Include database configuration file
require_once "connect.php";  

$district = $_SESSION['district'];
// Function to get member count for a specific membership type
function get_member_count($con, $membership, $district) {
    $sql = "SELECT COUNT(*) as count FROM members WHERE membership = ? AND district = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $membership, $district);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Membership types
$membership_types = [
    "Kerala Congress",
    "Kerala Students Congress (KSC)",
    "Kerala Youth Front (KYF)",
    "Kerala NGO Front",
    "Kerala Vanitha Congress",
    "Kerala Pravasi Congress",
    "Kerala Samskarika Vedi",
    "Kerala Sahakarana Forum",
    "Kerala Paddy Farmers Forum",
    "Kerala Fishermen Forum",
    "Kerala Information Technology Forum",
    "Kerala Karshaka Union",
    "Kerala Trade Union Congress (KTUC)",
    "Kerala Dalit Front",
    "Kerala Private Teachers Front",
    "Kerala Lawyers Front",
    "Kerala IT & Professional Congress (KITPROC)"
];

// Get member counts for each membership type
$member_counts = [];
foreach ($membership_types as $type) {
    $member_counts[$type] = get_member_count($con, $type, $district);
}

$username = $_SESSION['username']; // assuming you have a session variable for the username

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kerala Congress</title>
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
        .card-container {
            display: flex;
            flex-wrap: wrap;
        }
        .card {
            flex: 1 1 calc(33.333% - 10px);
            margin: 5px;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card h6 {
            background-color: #6c757d;
            margin: 0;
            padding: 15px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .card .links {
            display: flex;
            justify-content: space-around;
            background-color: #fff;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            padding: 10px;
        }
        .card .links a {
            flex: 1;
            margin: 0 5px;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            color: #000000;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
        }
        .card .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Kerala Congress</h3>
            <p><?php echo htmlspecialchars($username); ?></p>
        </div>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="get_card.php"><i class="fas fa-id-card"></i> Get Card</a>
        <a href="#"><i class="fas fa-money-check-alt"></i> Checkout Payments</a>
        <a href="find_member.php"><i class="fas fa-users"></i> Find Members</a>
        <a href="#"><i class="fas fa-key"></i> Change Password</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Home</a>
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

        <div class="container mt-4">
            <div class="content-header">
                <h2>District Secretary Dashboard</h2>
            </div>
            <div class="card-container">
                <?php foreach ($membership_types as $type): ?>
                <div class="card">
                    <h6><?php echo htmlspecialchars($type) . ' (' . $member_counts[$type] . ')'; ?></h6>
                    <div class="links">
                        <a href="fetch_members.php?membership=<?php echo urlencode($type); ?>">New members</a>
                        <a href="fetch_all_members.php?membership=<?php echo urlencode($type); ?>">All members</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

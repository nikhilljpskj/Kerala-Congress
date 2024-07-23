<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: dist_auth_log.html");
    exit;
}

// Include database configuration file
require_once "connect.php";

if (isset($_GET['export']) && $_GET['export'] == 'all') {
    // Handle the export request
    $search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";

    $sql = "SELECT * FROM members WHERE status = 1 AND 
            (fname LIKE ? OR lname LIKE ? OR mobile LIKE ? OR aadhaar LIKE ?)";

    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("ssss", $search, $search, $search, $search);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $members = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="members.xlsx"');
            echo json_encode($members); // Convert members data to JSON format
        } else {
            echo "Execution failed: " . $stmt->error;
        }
    } else {
        echo "Prepare failed: " . $con->error;
    }
    $con->close();
    exit;
}

// Regular pagination logic for displaying members
$limit = 10; // Number of rows per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";

$sql = "SELECT * FROM members WHERE status = 1 AND 
        (fname LIKE ? OR lname LIKE ? OR mobile LIKE ? OR aadhaar LIKE ?)
        LIMIT ? OFFSET ?";

if ($stmt = $con->prepare($sql)) {
    $stmt->bind_param("ssssii", $search, $search, $search, $search, $limit, $offset);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $members = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>Find a Member</title>
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
            <div class="content-header">
                <h2>Find a Member</h2>
                <input type="text" id="searchBox" class="form-control" style="width:200px" placeholder="Search...">
                <button id="downloadBtn" class="btn btn-success ml-2">Download as Excel</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Reg No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th hidden>Membership</th>
                        <th hidden>Blood</th>
                        <th hidden>Address</th>
                        <th hidden>Email</th>
                        <th>Gender</th>
                        <th>Aadhaar</th>
                        <th hidden>District</th>
                        <th>Assembly</th>
                        <th>Local Self</th>
                        <th hidden>Ward</th>
                        <th hidden>Reference</th>
                        <th>Photo</th>
                    </tr>
                </thead>
                <tbody id="memberTable">
                    <?php if (!empty($members)): ?>
                        <?php foreach ($members as $member): ?>
                            <tr class="member-row">
                                <td><a href="member_details.php?reg_no=<?php echo htmlspecialchars($member['reg_no']); ?>"><?php echo htmlspecialchars($member['reg_no']); ?></a></td>
                                <td><?php echo htmlspecialchars($member['fname'] . ' ' . $member['lname']); ?></td>
                                <td><?php echo htmlspecialchars($member['mobile']); ?></td>
                                <td hidden><?php echo htmlspecialchars($member['membership']); ?></td>
                                <td hidden><?php echo htmlspecialchars($member['blood']); ?></td>
                                <td hidden><?php echo htmlspecialchars($member['address']); ?></td>
                                <td hidden><?php echo htmlspecialchars($member['email']); ?></td>
                                <td><?php echo htmlspecialchars($member['gender']); ?></td>
                                <td><?php echo htmlspecialchars($member['aadhaar']); ?></td>
                                <td hidden><?php echo htmlspecialchars($member['district']); ?></td>
                                <td><?php echo htmlspecialchars($member['assembly']); ?></td>
                                <td><?php echo htmlspecialchars($member['selfgovt']); ?></td>
                                <td hidden><?php echo htmlspecialchars($member['ward']); ?></td>
                                <td hidden><?php echo htmlspecialchars($member['reference']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($member['photo']); ?>" class="photo" alt="Photo"></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No new members found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div id="paginationControls" class="d-flex justify-content-center mt-3">
                <button id="prevBtn" class="btn btn-primary mr-2" <?php echo $page <= 1 ? 'disabled' : ''; ?>>Previous</button>
                <button id="nextBtn" class="btn btn-primary" <?php echo count($members) < $limit ? 'disabled' : ''; ?>>Next</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchBox = document.getElementById("searchBox");
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");
            const memberTable = document.getElementById("memberTable");
            const downloadBtn = document.getElementById("downloadBtn");

            let currentPage = <?php echo $page; ?>;
            let currentSearch = '<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>';

            searchBox.value = currentSearch;

            searchBox.addEventListener("keyup", function() {
                currentSearch = searchBox.value;
                currentPage = 1;
                fetchMembers(currentSearch, currentPage);
            });

            prevBtn.addEventListener("click", function() {
                if (currentPage > 1) {
                    currentPage--;
                    fetchMembers(currentSearch, currentPage);
                }
            });

            nextBtn.addEventListener("click", function() {
                currentPage++;
                fetchMembers(currentSearch, currentPage);
            });

            downloadBtn.addEventListener("click", function() {
                downloadExcel();
            });

            function fetchMembers(search, page) {
                fetch(`find_member.php?search=${search}&page=${page}`)
                    .then(response => response.text())
                    .then(data => {
                        memberTable.innerHTML = new DOMParser().parseFromString(data, 'text/html').getElementById('memberTable').innerHTML;
                        updateButtonStates(memberTable.querySelectorAll('tr').length);
                    });
            }

            function updateButtonStates(resultsLength) {
                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = resultsLength < <?php echo $limit; ?>;
            }

            function downloadExcel() {
                fetch(`find_member.php?search=${currentSearch}&export=all`)
                    .then(response => response.json())
                    .then(data => {
                        const ws = XLSX.utils.json_to_sheet(data);
                        const wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, "Members");
                        XLSX.writeFile(wb, 'members.xlsx');
                    });
            }

            fetchMembers(currentSearch, currentPage); // Initial fetch
        });
    </script>
</body>
</html>
